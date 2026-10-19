<?php
require dirname(__DIR__).'/includes/bootstrap.php';require ROOT.'/includes/api.php';
$u=api_user();if($u['role']!=='admin')api_response(403,['ok'=>false,'message'=>'Admin access required.']);
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Allow: POST');api_response(405,['ok'=>false,'message'=>'Invalid request method.']);}
api_csrf();
try{
    if(!one("SHOW TABLES LIKE 'email_deliveries'"))throw new DomainException('Run database/upgrade_v4.sql to enable email diagnostics.');
    $mode=(string)($_POST['mode']??'check');
    if(!in_array($mode,['check','test'],true))throw new DomainException('Invalid request method.');
    $email=$mode==='test'?$u['email']:valid_email(text_input('email',190));
    $account=one('SELECT active,email_verified_at FROM users WHERE email=?',[$email]);
    $notice='';
    if($mode==='test'){
        throttle('email_test',(string)$u['id'],3,600);
        $heading=t('Your email connection works.');$copy=t('This is a Tripora delivery test. No password or verification code was changed.');
        try{
            deliver_email($email,$u['name'],['subject'=>'Tripora · '.t('Email delivery test'),'html'=>'<!doctype html><html lang="'.e(language()).'"><body><table role="presentation" width="100%" cellpadding="24"><tr><td><h1>Tripora</h1><h2>'.e($heading).'</h2><p>'.e($copy).'</p></td></tr></table></body></html>','text'=>$heading."\n\n".$copy]);
            log_email_delivery($email,'test','accepted','The SMTP server accepted the message. Check Inbox and Spam.');
            $notice=t('The SMTP server accepted the test email. Check your admin Inbox and Spam.');
        }catch(DomainException $ex){log_email_delivery($email,'test','failed',$ex->getMessage());throw $ex;}
    }
    $config=require ROOT.'/config/mail.php';$configurationError=mail_configuration_error($config);
    $status=!$account?'No account matches this email.':(!(int)$account['active']?'This account is inactive.':'This account is active.');
    $deliveries=all('SELECT purpose,status,detail,created_at FROM email_deliveries WHERE email=? ORDER BY id DESC LIMIT 5',[$email]);
    foreach($deliveries as &$delivery){$delivery['status']=t(['accepted'=>'SMTP accepted','failed'=>'Failed','skipped'=>'Not sent'][$delivery['status']]);$delivery['detail']=t($delivery['detail']);}unset($delivery);
    api_response(200,['ok'=>true,'message'=>$notice?:t('Email check complete.'),'email'=>$email,'account'=>t($status),'configuration'=>$configurationError?t($configurationError):t('SMTP settings are present. Send a test email to check the connection.'),'deliveries'=>$deliveries]);
}catch(DomainException $ex){api_response(422,['ok'=>false,'message'=>$ex->getMessage()]);}
catch(Throwable $ex){api_response(500,['ok'=>false,'message'=>'The email check could not be completed. Please try again.']);}
