<?php
switch($action){
        case 'register':
            throttle('register',$_SERVER['REMOTE_ADDR']??'local',5);
            $name=text_input('name',120);$email=valid_email(text_input('email',190));$pass=password_input();
            if(one('SELECT id FROM users WHERE email=?',[$email]))throw new DomainException('This email is already registered. Please sign in or reset your password.');
            query("INSERT INTO users (name,email,password_hash,role) VALUES (?,?,?,'customer')",[$name,$email,password_hash($pass,PASSWORD_DEFAULT)]);
            $_SESSION['verify_email']=$email;send_code($email,$name,'verify');
            flash('A verification code has been sent.','info');redirect('verify');
        case 'verify':
            $email=$_SESSION['verify_email']??'';
            verify_code($email,'verify',otp_input());
            query('UPDATE users SET email_verified_at=UTC_TIMESTAMP() WHERE email=?',[$email]);
            unset($_SESSION['verify_email']);flash('Email verified. You can now sign in.');redirect('login');
        case 'resend':
            resend_otp('verify');flash('A new verification code has been sent.');redirect('verify');
        case 'admin_login':
        case 'login':
            if($page!==$action)throw new DomainException('Use the correct sign-in page for this account.');
            $email=valid_email(text_input('email',190));
            throttle('login',($email.'|'.($_SERVER['REMOTE_ADDR']??'local')),8);
            $u=one('SELECT * FROM users WHERE email=? AND active=1',[$email]);
            if(!$u||!password_verify((string)($_POST['password']??''),$u['password_hash']))throw new DomainException('The email or password is incorrect.');
            if($action==='admin_login'&&$u['role']!=='admin')throw new DomainException('An administrator account is required for this page.');
            if($action==='login'&&$u['role']!=='customer')throw new DomainException('Use the administrator sign-in page for this account.');
            if(!$u['email_verified_at']){$_SESSION['verify_email']=$email;flash('Verify your email before signing in. Request a new code below.','info');redirect('verify');}
            session_regenerate_id(true);$_SESSION['user_id']=$u['id'];$_SESSION['auth_version']=(int)$u['auth_version'];unset($_SESSION['csrf']);
            flash('Welcome back, '.$u['name'].'.');redirect($u['role']==='admin'?'admin':'home');
        case 'admin_logout':
        case 'logout':
            $_SESSION=[];session_regenerate_id(true);redirect($action==='admin_logout'?'admin_login':'home');
        case 'forgot':
            $email=valid_email(text_input('email',190));throttle('forgot',$_SERVER['REMOTE_ADDR']??'local',5);
            $u=one('SELECT * FROM users WHERE email=? AND active=1',[$email]);
            unset($_SESSION['reset_grant']);$_SESSION['reset_email']=$email;
            if($u)send_code($email,$u['name'],'reset');
            else {$_SESSION['otp_cooldowns']['reset']=['email'=>$email,'until'=>time()+60];log_email_delivery($email,'reset','skipped','No active account matches this email. No email was sent.');}
            flash('If the account exists, a reset code has been sent.','info');redirect('reset');
        case 'reset_resend':
            resend_otp('reset');
            flash('If the account exists, a reset code has been sent.','info');redirect('reset');
        case 'reset_verify':
            $email=$_SESSION['reset_email']??'';
            throttle('reset_verify',$email.'|'.($_SERVER['REMOTE_ADDR']??'local'),15);
            $u=one('SELECT * FROM users WHERE email=? AND active=1',[$email]);
            if(!$u)throw new DomainException('The code expired. Please request a new code.');
            verify_code($email,'reset',otp_input());
            $_SESSION['reset_grant']=['user_id'=>(int)$u['id'],'email'=>$u['email'],'auth_version'=>(int)$u['auth_version'],'expires'=>time()+600];
            session_regenerate_id(true);flash('Code verified. You can now set your new password.');redirect('reset');
        case 'reset':
            $u=reset_password_grant();
            if(!$u)throw new DomainException('Verify a new code before changing your password.');
            replace_password($u,confirmed_password_input());
            unset($_SESSION['reset_email'],$_SESSION['reset_grant'],$_SESSION['password_change'],$_SESSION['user_id'],$_SESSION['auth_version']);
            session_regenerate_id(true);flash('Password updated. Please sign in.');redirect($u['role']==='admin'?'admin_login':'login');
        case 'setup':
            $back='setup';
            if(one("SELECT id FROM users WHERE role='admin'"))throw new DomainException('An administrator already exists.');
            $token=env('SETUP_TOKEN');$local=in_array($_SERVER['REMOTE_ADDR']??'', ['127.0.0.1','::1'],true);
            if(($token!==''&&!hash_equals($token,(string)($_POST['setup_token']??''))) || ($token===''&&!$local))throw new DomainException('Set SETUP_TOKEN in .env to create an administrator remotely.');
            $email=valid_email(text_input('email',190));$pass=password_input();$name=text_input('name',120);
            $db->beginTransaction();
            $lock=one("SELECT setting_value FROM settings WHERE setting_key='setup_lock' FOR UPDATE");
            if(!$lock||one("SELECT id FROM users WHERE role='admin'"))throw new DomainException('Administrator setup is unavailable.');
            query("INSERT INTO users (name,email,password_hash,role,email_verified_at) VALUES (?,?,?,'admin',UTC_TIMESTAMP())",[$name,$email,password_hash($pass,PASSWORD_DEFAULT)]);
            $db->commit();flash('Administrator created. Sign in with your new account.');redirect('admin_login');
default: throw new DomainException('Unknown form action.');
}
