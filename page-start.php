<?php
expire_holds();
require ROOT.'/includes/actions.php';
if(in_array($page,['saved','trips','booking'],true))require_customer();
if($page==='profile')require_user();
if($page==='change'){
    $account=require_user();
    if(!change_password_state($account)){flash('Start the password change from your profile.','info');redirect('profile');}
}
if($page==='reset'&&empty($_SESSION['reset_email']))redirect('forgot');
if($page==='verify'&&!one('SELECT id FROM users WHERE email=? AND active=1 AND email_verified_at IS NULL',[$_SESSION['verify_email']??''])){
    unset($_SESSION['verify_email']);redirect('register');
}
if($page==='admin')require_admin();
if($page==='admin_login'&&$user&&$user['role']==='admin')redirect('admin');
$today=gmdate('Y-m-d');$tomorrow=gmdate('Y-m-d',strtotime('+1 day'));
$in=(string)($_GET['check_in']??$today);$out=(string)($_GET['check_out']??$tomorrow);$guests=max(1,min(12,(int)($_GET['guests']??2)));
$titles=['home'=>'Thoughtful stays, memorable journeys','explore'=>'Explore countries','stays'=>'Find a stay','saved'=>'Your saved stays','trips'=>'Your trips','profile'=>'Your account','admin'=>'Administration','admin_login'=>'Administrator sign in'];
$title=$titles[$page]??ucfirst(str_replace('_',' ',$page));
ob_start();
require ROOT.'/includes/header.php';
if($page==='admin')require ROOT.'/includes/admin/start.php';
else echo '<main>';
