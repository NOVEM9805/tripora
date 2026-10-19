<?php
require_once __DIR__.'/email-template.php';

function otp_delivery_error(string $detail,int $smtpCode=0): string {
    if(in_array($smtpCode,[530,534,535],true)||stripos($detail,'authenticate')!==false)
        return 'Email sign-in failed. The site owner must check SMTP_USER and the Gmail App Password in .env.';
    if(in_array($smtpCode,[421,450,451,452,454],true))
        return 'The email server is temporarily refusing mail. Please try again later.';
    if(in_array($smtpCode,[550,551,552,553,554],true))
        return 'The email server rejected this message. Check the account email address and the sender SMTP settings.';
    return 'The email could not be sent. The site owner must check the SMTP connection, TLS and internet access. Please try again.';
}
function mail_configuration_error(array $config): string {
    if($config['username']===''||$config['password']===''||!filter_var($config['from'],FILTER_VALIDATE_EMAIL)){
        return 'Email delivery is not configured. Add your Gmail address and Gmail App Password to the SMTP settings in .env.';
    }
    if($config['host']===''||str_contains($config['host'],'@'))return 'Set SMTP_HOST to smtp.gmail.com in .env.';
    if(!in_array($config['encryption'],['tls','ssl'],true)||$config['port']<1||$config['port']>65535)return 'Check the SMTP port and encryption settings in .env.';
    if(strtolower($config['host'])==='smtp.gmail.com'&&(!filter_var($config['username'],FILTER_VALIDATE_EMAIL)||!in_array([$config['port'],$config['encryption']],[[587,'tls'],[465,'ssl']],true)))return 'For Gmail, use your full email address with port 587 / tls or port 465 / ssl.';
    return '';
}
function log_email_delivery(string $email,string $purpose,string $status,string $detail): void {
    // Operational metadata only: never persist codes, credentials or raw SMTP replies.
    try{
        if(!one("SHOW TABLES LIKE 'email_deliveries'"))return;
        query('INSERT INTO email_deliveries(email,purpose,status,detail) VALUES(?,?,?,?)',[$email,$purpose,$status,$detail]);
        query('DELETE FROM email_deliveries WHERE created_at<DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 DAY) LIMIT 100');
    }catch(Throwable $ex){error_log('Tripora: email delivery metadata could not be recorded.');}
}
function deliver_otp(string $email,string $name,string $kind,string $code): void {
    try{
        deliver_email($email,$name,otp_email_content($email,$name,$kind,$code,language()));
        log_email_delivery($email,$kind,'accepted','The SMTP server accepted the message. Check Inbox and Spam.');
    }catch(Throwable $ex){
        log_email_delivery($email,$kind,'failed',$ex instanceof DomainException?$ex->getMessage():'Email delivery failed.');throw $ex;
    }
}
function deliver_email(string $email,string $name,array $content): void {
    $config=require ROOT.'/config/mail.php';
    if($error=mail_configuration_error($config))throw new DomainException($error);
    require_once ROOT.'/vendor/autoload.php';
    $mail=new PHPMailer\PHPMailer\PHPMailer(true);
    // PHPMailer closes the connection before reporting rejected recipients.
    // Retain only the numeric failure code before QUIT clears the SMTP error.
    $transport=new class extends PHPMailer\PHPMailer\SMTP {
        public int $failureCode=0;
        protected function sendCommand($command,$commandstring,$expect) {
            $ok=parent::sendCommand($command,$commandstring,$expect);
            if(!$ok)$this->failureCode=(int)($this->getError()['smtp_code']??0);
            return $ok;
        }
    };
    $mail->setSMTPInstance($transport);
    try{
        $mail->isSMTP();$mail->Host=$config['host'];$mail->Port=$config['port'];$mail->SMTPAuth=true;
        $mail->Username=$config['username'];$mail->Password=$config['password'];$mail->SMTPSecure=$config['encryption'];
        $mail->CharSet='UTF-8';$mail->Timeout=15;
        $mail->setFrom($config['from'],'Tripora');$mail->addAddress($email,$name);
        $mail->isHTML(true);$mail->Subject=$content['subject'];
        $mail->Body=$content['html'];$mail->AltBody=$content['text'];
        $mail->send();
    }catch(Throwable $ex){
        // Classify errors without exposing SMTP responses, passwords or OTPs to visitors.
        throw new DomainException(otp_delivery_error($mail->ErrorInfo,$transport->failureCode));
    }
}
