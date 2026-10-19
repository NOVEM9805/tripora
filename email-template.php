<?php
/** Pure template: no database, SMTP, tracking images or client-side scripting. */
function otp_email_content(string $email,string $name,string $kind,string $code,string $locale='en'): array {
    if(!in_array($kind,['verify','reset','change'],true)||!preg_match('/^[0-9]{6}$/D',$code))throw new InvalidArgumentException('Invalid OTP email content.');
    $my=$locale==='my';$locale=$my?'my':'en';
    $purposes=$my?[
        'verify'=>['Tripora အီးမေးလ် အတည်ပြုကုဒ်','သင့်အီးမေးလ်ကို အတည်ပြုပါ','အကောင့်အသစ်ဖွင့်ရန်','Tripora အကောင့်ဖွင့်ခြင်းကို အပြီးသတ်ရန် အောက်ပါကုဒ်ကို အတည်ပြုစာမျက်နှာတွင် ထည့်ပါ။'],
        'reset'=>['Tripora စကားဝှက် ပြန်သတ်မှတ်ရန် ကုဒ်','စကားဝှက်ကို ပြန်သတ်မှတ်ပါ','စကားဝှက် ပြန်သတ်မှတ်ရန်','သင့်စကားဝှက်ကို ပြန်သတ်မှတ်ရန် တောင်းဆိုမှု ရရှိထားပါသည်။ အောက်ပါကုဒ်ကို Tripora တွင် အတည်ပြုပြီးမှ စကားဝှက်အသစ် ထည့်နိုင်ပါမည်။'],
        'change'=>['Tripora စကားဝှက် ပြောင်းရန် ကုဒ်','စကားဝှက် ပြောင်းခြင်းကို အတည်ပြုပါ','စကားဝှက် ပြောင်းရန်','သင့်အကောင့်၏ စကားဝှက်ကို ပြောင်းရန် တောင်းဆိုမှု ရရှိထားပါသည်။ အောက်ပါကုဒ်ကို Tripora တွင် အတည်ပြုပြီးမှ စကားဝှက်အသစ် ထည့်နိုင်ပါမည်။'],
    ]:[
        'verify'=>['Verify your Tripora email','Verify your email','Account verification','One small step before your next journey. Enter the code below on the Tripora verification page to finish creating your account.'],
        'reset'=>['Reset your Tripora password','Reset your password','Password reset','We received a request to reset your Tripora password. Enter this code on Tripora first, then choose your new password.'],
        'change'=>['Change your Tripora password','Confirm your password change','Password change','You requested a password change for your Tripora account. Enter this code on Tripora first, then choose your new password.'],
    ];
    [$subject,$title,$purpose,$intro]=$purposes[$kind];
    $copy=$my?[
        'security'=>'အကောင့် လုံခြုံရေး','greeting'=>'မင်္ဂလာပါ','label'=>'သင့်အတည်ပြုကုဒ်','expiry'=>'၁၀ မိနစ်အတွင်း အသုံးပြုပါ','instruction'=>'ဤကုဒ်ကို ကူးယူပြီး Tripora အတည်ပြုစာမျက်နှာတွင် ထည့်ပါ။','account'=>'အကောင့် အီးမေးလ်','purpose'=>'တောင်းဆိုမှု','requested'=>'တောင်းဆိုသည့်အချိန်','warning'=>'ဤကုဒ်ကို မည်သူ့ကိုမျှ မပေးပါနှင့်။','notice'=>'Tripora ဝန်ထမ်းများက သင့်စကားဝှက် သို့မဟုတ် OTP ကို chat မှတစ်ဆင့် တောင်းမည်မဟုတ်ပါ။','ignore'=>'သင်တောင်းဆိုထားခြင်းမရှိလျှင် ဤအီးမေးလ်ကို လျစ်လျူရှုနိုင်ပါသည်။ ဤအီးမေးလ်တစ်ခုတည်းကြောင့် သင့်စကားဝှက် ပြောင်းသွားမည်မဟုတ်ပါ။','closing'=>'သင့်ခရီးစဉ်တိုင်းအတွက်','team'=>'Tripora အဖွဲ့','footer'=>'Tripora အကောင့်လုံခြုံရေးအတွက် အလိုအလျောက် ပို့ထားသော အီးမေးလ်ဖြစ်ပါသည်။','preheader'=>'သင့် Tripora အတည်ပြုကုဒ်။ ၁၀ မိနစ်အတွင်း အသုံးပြုပါ။',
    ]:[
        'security'=>'ACCOUNT SECURITY','greeting'=>'Hello','label'=>'YOUR VERIFICATION CODE','expiry'=>'Valid for 10 minutes','instruction'=>'Copy this code and enter it on the Tripora verification page.','account'=>'Account email','purpose'=>'Request','requested'=>'Requested at','warning'=>'Keep this code to yourself.','notice'=>'Tripora staff will never ask for your password or OTP in a chat.','ignore'=>'If you did not request this code, you can safely ignore this email. This email alone does not change your password.','closing'=>'Here for your next journey,','team'=>'The Tripora team','footer'=>'This automated email was sent to help protect your Tripora account.','preheader'=>'Your Tripora verification code. Valid for 10 minutes.',
    ];
    $timestamp=gmdate('d M Y, H:i').' UTC';
    $safe=static fn(string $v):string=>htmlspecialchars($v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');
    $s=array_map($safe,$copy);$n=$safe($name);$address=$safe($email);$heading=$safe($title);$description=$safe($intro);$request=$safe($purpose);
    ob_start(); ?>
<!doctype html>
<html lang="<?=$locale?>"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=$safe($subject)?></title></head>
<body style="margin:0;padding:0;background-color:#f4f1eb;color:#243b32;font-family:Arial,'Myanmar Text','Noto Sans Myanmar',sans-serif;line-height:1.7;">
<div style="display:none;max-height:0;overflow:hidden;opacity:0;mso-hide:all;"><?=$s['preheader']?></div>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f1eb"><tr><td align="center" style="padding:24px 12px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background-color:#ffffff;border:1px solid #e4e8e1;border-radius:16px;overflow:hidden;">
<tr><td bgcolor="#173e32" style="padding:26px 24px;color:#ffffff;border-radius:16px 16px 0 0;">
<div style="font-family:Georgia,serif;font-size:34px;font-weight:bold;letter-spacing:-1px;line-height:1.2;">Tripora<span style="color:#e6ad8c;">.</span></div>
<div style="font-size:11px;letter-spacing:2px;padding-top:8px;color:#d4e5da;">STAYS &middot; JOURNEYS &middot; MEMORIES</div>
</td></tr>
<tr><td style="padding:28px 24px 12px;">
<div style="color:#a85b3d;font-size:12px;font-weight:bold;letter-spacing:1px;"><?=$s['security']?></div>
<h1 style="margin:8px 0 18px;color:#173e32;font-size:26px;line-height:1.4;"><?=$heading?></h1>
<p style="margin:0 0 12px;font-size:16px;"><?=$s['greeting']?> <?=$n?>,</p>
<p style="margin:0;font-size:15px;color:#526158;"><?=$description?></p>
</td></tr>
<tr><td style="padding:16px 24px 24px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f8f3ea" style="border:1px solid #e6ddcb;border-radius:12px;"><tr><td align="center" style="padding:22px 10px;">
<div style="color:#6b7166;font-size:12px;font-weight:bold;letter-spacing:1px;"><?=$s['label']?></div>
<div dir="ltr" style="font-family:'Courier New',monospace;font-size:36px;font-weight:bold;letter-spacing:5px;line-height:1.5;color:#173e32;padding:8px 0;white-space:nowrap;"><?=$code?></div>
<div style="color:#a85b3d;font-size:13px;font-weight:bold;"><?=$s['expiry']?></div>
</td></tr></table>
<p style="margin:12px 0 0;text-align:center;color:#68766d;font-size:13px;"><?=$s['instruction']?></p>
</td></tr>
<tr><td style="padding:0 24px 22px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top:1px solid #e7ece7;font-size:13px;">
<tr><td style="padding:16px 0 4px;color:#718077;"><?=$s['account']?></td></tr>
<tr><td style="color:#243b32;word-break:break-all;"><?=$address?></td></tr>
<tr><td style="padding-top:12px;color:#718077;"><?=$s['purpose']?>: <span style="color:#243b32;"><?=$request?></span></td></tr>
<tr><td style="padding-top:4px;color:#718077;"><?=$s['requested']?>: <span style="color:#243b32;"><?=$timestamp?></span></td></tr>
</table></td></tr>
<tr><td style="padding:0 24px 24px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#edf3ed" style="border-radius:10px;"><tr><td style="padding:16px;font-size:13px;color:#3e5848;">
<strong><?=$s['warning']?></strong><br><?=$s['notice']?>
</td></tr></table>
<p style="font-size:13px;color:#68766d;margin:16px 0 22px;"><?=$s['ignore']?></p>
<p style="font-size:14px;margin:0;color:#526158;"><?=$s['closing']?><br><strong style="color:#173e32;"><?=$s['team']?></strong></p>
</td></tr>
</table>
<div style="max-width:520px;padding:16px 12px 0;text-align:center;color:#78847a;font-size:11px;"><?=$s['footer']?><br>&copy; <?=gmdate('Y')?> Tripora</div>
</td></tr></table>
</body></html>
<?php $html=ob_get_clean();
    $text="{$copy['greeting']} $name,\n\n$title\n$intro\n\n";
    $text.=$my?"သင့် Tripora အတည်ပြုကုဒ် — $code\n":"Your Tripora $kind code is: $code\n";
    $text.="{$copy['expiry']}\n{$copy['instruction']}\n\n{$copy['account']}: $email\n{$copy['purpose']}: $purpose\n{$copy['requested']}: $timestamp\n\n{$copy['warning']}\n{$copy['notice']}\n\n{$copy['ignore']}\n\n{$copy['team']}";
    return ['subject'=>$subject,'html'=>$html,'text'=>$text];
}
