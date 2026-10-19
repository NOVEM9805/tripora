<?php
require dirname(__DIR__).'/includes/bootstrap.php';require ROOT.'/includes/api.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Allow: POST');api_response(405,['ok'=>false,'message'=>'Invalid request method.']);}
api_csrf();$context=is_string($_POST['context']??null)?$_POST['context']:'';
if($context==='change')api_user();
try{
    $remaining=otp_cooldown($context);
    if($remaining>0){header('Retry-After: '.$remaining);api_response(429,['ok'=>false,'message'=>'Wait one minute before requesting another code.','retry_after'=>$remaining]);}
    resend_otp($context);
    api_response(200,['ok'=>true,'message'=>$context==='reset'?'If the account exists, a reset code has been sent.':'A new verification code has been sent.','retry_after'=>otp_cooldown($context)]);
}catch(DomainException $ex){
    $limited=str_starts_with($ex->getMessage(),'Too many attempts.');
    api_response($limited?429:422,['ok'=>false,'message'=>$ex->getMessage()]);
}catch(Throwable $ex){api_response(500,['ok'=>false,'message'=>'The code could not be sent. Please try again.']);}
