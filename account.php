<?php
// Private profile images and session-bound, one-use password verification.
function profile_initial(array $u): string {
    return preg_match('/^./us',trim($u['name']),$match)?strtoupper($match[0]):'?';
}
function avatar_url(array $u): string {
    return asset('customer/avatar.php').'?v='.substr(hash('sha256',(string)($u['profile_image']??'')),0,12);
}
function remove_profile_image(string $name): void {
    if(preg_match('/^[a-f0-9]{32}\.(jpg|png|webp)$/D',$name)&&is_file(ROOT.'/storage/private/'.$name))unlink(ROOT.'/storage/private/'.$name);
}
function update_profile(array $u): void {
    $name=text_input('name',120);$phone=text_input('phone',40,false);
    $upload=isset($_FILES['profile_photo'])&&($_FILES['profile_photo']['error']??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_NO_FILE;
    $remove=($_POST['remove_photo']??'')==='1';$new='';$old=(string)($u['profile_image']??'');
    if(($upload||$remove)&&!array_key_exists('profile_image',$u))throw new DomainException('Run database/upgrade_v3.sql before adding a profile photo.');
    if($upload)$new=save_upload('profile_photo',true);
    try {
        if($upload||$remove)query('UPDATE users SET name=?,phone=?,profile_image=? WHERE id=?',[$name,$phone,$new,$u['id']]);
        else query('UPDATE users SET name=?,phone=? WHERE id=?',[$name,$phone,$u['id']]);
    }catch(Throwable $ex){if($new!=='')remove_profile_image($new);throw $ex;}
    if(($upload||$remove)&&$old!==''&&$old!==$new)remove_profile_image($old);
}
function otp_input(): string {
    $code=$_POST['code']??'';
    if(!is_string($code))throw new DomainException('Enter all six digits of the verification code.');
    if($code===''){
        $digits=$_POST['digits']??[];
        if(!is_array($digits)||count($digits)!==6)throw new DomainException('Enter all six digits of the verification code.');
        foreach($digits as $digit)if(!is_string($digit)||!preg_match('/^[0-9]$/D',$digit))throw new DomainException('Enter all six digits of the verification code.');
        $code=implode('',$digits);
    }
    if(!preg_match('/^[0-9]{6}$/D',$code))throw new DomainException('Enter all six digits of the verification code.');
    return $code;
}
function confirmed_password_input(): string {
    $password=password_input();
    if(!isset($_POST['password_confirmation'])||!is_string($_POST['password_confirmation'])||!hash_equals($password,$_POST['password_confirmation']))throw new DomainException('The passwords do not match.');
    return $password;
}
function change_password_state(array $u): ?array {
    $state=$_SESSION['password_change']??null;
    if(!is_array($state)||($state['user_id']??0)!==(int)$u['id']||($state['auth_version']??-1)!==(int)$u['auth_version']||($state['email']??'')!==$u['email']||($state['expires']??0)<=time()){
        unset($_SESSION['password_change']);return null;
    }
    return $state;
}
function reset_password_grant(): ?array {
    $grant=$_SESSION['reset_grant']??null;
    if(!is_array($grant)||($grant['expires']??0)<=time()||($grant['email']??'')!==($_SESSION['reset_email']??'')){
        unset($_SESSION['reset_grant']);return null;
    }
    $u=one('SELECT * FROM users WHERE id=? AND email=? AND active=1',[$grant['user_id']??0,$grant['email']]);
    if(!$u||(int)$u['auth_version']!==($grant['auth_version']??-1)){unset($_SESSION['reset_grant']);return null;}
    return $u;
}
function replace_password(array $u,string $password): void {
    global $db;
    $db->beginTransaction();
    try{
        $result=query('UPDATE users SET password_hash=?,auth_version=auth_version+1 WHERE id=? AND email=? AND active=1 AND auth_version=?',[password_hash($password,PASSWORD_DEFAULT),$u['id'],$u['email'],$u['auth_version']]);
        if($result->rowCount()!==1)throw new DomainException('Verify a new code before changing your password.');
        query("DELETE FROM auth_tokens WHERE email=? AND kind IN ('reset','change')",[$u['email']]);
        $db->commit();
    }catch(Throwable $ex){if($db->inTransaction())$db->rollBack();throw $ex;}
}
