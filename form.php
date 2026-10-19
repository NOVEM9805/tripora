<?php
$formPage=$page==='admin_login'?'login':$page;$adminLogin=$page==='admin_login';
$passwordFlow=in_array($formPage,['reset','change'],true);
$verified=$formPage==='reset'?reset_password_grant()!==null:($formPage==='change'?(change_password_state($user)['stage']??'')==='password':false);
$otpStage=$formPage==='verify'||($passwordFlow&&!$verified);
$formAction=$formPage;
if($formPage==='change')$formAction=$verified?'password':'password_verify';
if($formPage==='reset')$formAction=$verified?'reset':'reset_verify';
if($adminLogin)$formAction='admin_login';
$headings=['login'=>$adminLogin?'Admin|sign in.':'Welcome|back.','register'=>'Create your|account.','verify'=>'Check your|inbox.','forgot'=>'A fresh|start.','reset'=>$verified?'Set your|new password.':'Check your|inbox.','change'=>$verified?'Set your|new password.':'Check your|inbox.'];
[$headline,$emphasis]=explode('|',$headings[$formPage]);
$email=$formPage==='change'?$user['email']:($_SESSION[$formPage==='verify'?'verify_email':'reset_email']??t('your email'));
?>
<section class="wrap section auth-shell"><div class="auth-visual"><img src="<?=e(asset('public/images/bali.jpg'))?>" alt="<?=e(t('A scenic destination in Bali'))?>"><div><h2><?=e(t('Good places.'))?><br><em><?=e(t('Better memories.'))?></em></h2><p><?=e(t('A little wonder is waiting.'))?></p></div></div><div class="auth-form">
<p class="eyebrow"><?=e(t($adminLogin?'TRIPORA ADMIN':'WELCOME TO TRIPORA'))?></p><h1 class="auth-title"><?=e(t($headline))?> <em><?=e(t($emphasis))?></em></h1>
<?php if($passwordFlow): ?><ol class="password-steps" aria-label="<?=e(t('Password reset steps'))?>"><li class="<?=$verified?'completed':'current'?>" <?=$verified?'':'aria-current="step"'?>>1. <?=e(t('Verify code'))?></li><li class="<?=$verified?'current':''?>" <?=$verified?'aria-current="step"':''?>>2. <?=e(t('New password'))?></li></ol><?php endif ?>
<?php if($otpStage): ?><p class="muted"><?=e(t('Enter the six-digit code sent to'))?> <strong><?=e($email)?></strong>.</p><?php elseif($passwordFlow): ?><p class="verification-badge">✓ <?=e(t('Email verified. Set your new password below.'))?></p><?php endif ?>
<form method="post" class="stack"><?=csrf()?><input type="hidden" name="action" value="<?=e($formAction)?>">
<?php if($formPage==='register'): ?><label><?=e(t('Your name'))?><input name="name" maxlength="120" autocomplete="name" required></label><?php endif ?>
<?php if(in_array($formPage,['login','register','forgot'])): ?><label><?=e(t('Email address'))?><input name="email" type="email" maxlength="190" autocomplete="email" required></label><?php endif ?>
<?php if($otpStage)require ROOT.'/includes/auth/otp-input.php'; ?>
<?php if(in_array($formPage,['login','register'])||($passwordFlow&&$verified)): ?><label><?=e(t($passwordFlow?'New password':'Password'))?><input name="password" type="password" minlength="8" maxlength="72" autocomplete="<?=$formPage==='login'?'current-password':'new-password'?>" required></label><?php endif ?>
<?php if($passwordFlow&&$verified): ?><label><?=e(t('Confirm new password'))?><input name="password_confirmation" type="password" minlength="8" maxlength="72" autocomplete="new-password" required></label><small class="muted"><?=e(t('Use 8–72 characters. Your other signed-in sessions will be signed out.'))?></small><?php endif ?>
<button class="button"><?=e(t($otpStage?($formPage==='verify'?'Verify email':'Verify code'):($passwordFlow?'Save new password':['login'=>'Sign in','register'=>'Create account','forgot'=>'Send reset code'][$formPage])))?> ↗</button></form>
<?php if($formPage==='login'&&!$adminLogin): ?><p class="muted"><?=e(t('Customer accounts only.'))?> <a class="text-link" href="<?=e(url('admin_login'))?>"><?=e(t('Administrator sign in ↗'))?></a></p><p><a class="text-link" href="<?=e(url('forgot'))?>"><?=e(t('Forgot your password?'))?></a></p><p><?=e(t('New here?'))?> <a class="text-link" href="<?=e(url('register'))?>"><?=e(t('Create an account ↗'))?></a></p>
<?php elseif($adminLogin): ?><p><a class="text-link" href="<?=e(url('forgot'))?>"><?=e(t('Forgot your password?'))?></a></p><p><?=e(t('First time?'))?> <a class="text-link" href="<?=e(url('setup'))?>"><?=e(t('Create your first administrator ↗'))?></a></p>
<?php elseif($formPage==='register'): ?><p><?=e(t('Already have an account?'))?> <a class="text-link" href="<?=e(url('login'))?>"><?=e(t('Sign in'))?></a></p>
<?php elseif($otpStage): ?><?php $remaining=otp_cooldown($formPage); ?><form class="otp-resend" method="post" data-otp-resend data-endpoint="<?=e(asset('api/otp-resend.php'))?>" data-retry-after="<?=e($remaining)?>"><input type="hidden" name="context" value="<?=e($formPage)?>"><?=csrf()?><input type="hidden" name="action" value="<?=e(['verify'=>'resend','reset'=>'reset_resend','change'=>'password_resend'][$formPage])?>"><button class="text-link plain"><?=e(t('Send a new code ↗'))?></button><span class="resend-countdown" role="timer" aria-live="off" data-resend-countdown hidden></span><p class="muted resend-feedback" role="status" data-resend-feedback></p></form><p class="muted"><?=e(t('Codes expire after 10 minutes. Wait one minute before requesting another.'))?></p>
<?php endif ?>
<?php if($formPage==='reset'): ?><p class="muted"><?=e(t('Use the email address registered with Tripora. Check Inbox and Spam.'))?> <a class="text-link" href="<?=e(url('forgot'))?>"><?=e(t('Change email address'))?></a></p><?php endif ?>
<?php if($formPage==='change'): ?><p><a class="text-link" href="<?=e(url('profile'))?>"><?=e(t('Back to profile'))?></a></p><?php elseif(in_array($formPage,['forgot','reset'],true)): ?><p><a class="text-link" href="<?=e(url('login'))?>"><?=e(t('Back to sign in'))?></a></p><?php endif ?>
</div></section>
