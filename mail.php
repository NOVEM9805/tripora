<?php
// OTP always uses authenticated SMTP. No outbox/file-delivery fallback.
$username=trim(env('SMTP_USER'));
$host=trim(env('SMTP_HOST','smtp.gmail.com'));
$password=env('SMTP_PASS');
// Google displays App Passwords in groups. Pasted display spaces are not part of the password.
if(strtolower($host)==='smtp.gmail.com')$password=preg_replace('/\s+/','',$password);
return [
    'host'=>$host,
    'port'=>(int)env('SMTP_PORT','587'),
    'encryption'=>strtolower(trim(env('SMTP_ENCRYPTION','tls'))),
    'username'=>$username,
    'password'=>$password,
    'from'=>trim(env('SMTP_FROM'))?:$username,
];
