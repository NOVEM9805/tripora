<?php
function otp_context(string $context): array {
    global $user;
    if($context==='change'){
        if(!$user)throw new DomainException('Please sign in to continue.');
        $state=change_password_state($user);
        if(!$state||$state['stage']!=='otp')throw new DomainException('Start the password change from your profile.');
        return [$user['email'],$user,'change'];
    }
    if($context==='verify'){
        $email=$_SESSION['verify_email']??'';
        $u=one('SELECT * FROM users WHERE email=? AND email_verified_at IS NULL AND active=1',[$email]);
        if(!$u)throw new DomainException('Start registration or sign in first.');
        return [$email,$u,'verify'];
    }
    if($context==='reset'){
        $email=$_SESSION['reset_email']??'';
        if($email==='')throw new DomainException('Request a password reset code first.');
        return [$email,one('SELECT * FROM users WHERE email=? AND active=1',[$email]),'reset'];
    }
    throw new DomainException('Invalid code request.');
}
function otp_cooldown(string $context): int {
    [$email,$u,$kind]=otp_context($context);
    $token=one('SELECT created_at FROM auth_tokens WHERE email=? AND kind=?',[$email,$kind]);
    $until=$token?strtotime($token['created_at'])+60:0;
    $remembered=$_SESSION['otp_cooldowns'][$kind]??null;
    if(is_array($remembered)&&($remembered['email']??'')===$email)$until=max($until,(int)($remembered['until']??0));
    return max(0,$until-time());
}
function resend_otp(string $context): void {
    [$email,$u,$kind]=otp_context($context);
    if($context==='reset'&&reset_password_grant())throw new DomainException('Your code is already verified. Continue with your new password.');
    if(otp_cooldown($context)>0)throw new DomainException('Wait one minute before requesting another code.');
    $scope=['verify'=>'resend','reset'=>'reset_resend','change'=>'password_resend'][$context];
    throttle($scope,$context==='change'?(string)$u['id']:($_SERVER['REMOTE_ADDR']??'local'),5);
    if($u)send_code($email,$u['name'],$kind);
    else {$_SESSION['otp_cooldowns'][$kind]=['email'=>$email,'until'=>time()+60];log_email_delivery($email,$kind,'skipped','No active account matches this email. No email was sent.');}
    if($context==='change'){
        $_SESSION['password_change']['expires']=time()+600;
    }elseif($context==='reset')unset($_SESSION['reset_grant']);
}
