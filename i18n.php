<?php
$requested=$_GET['lang']??null;
$language=in_array($requested,['en','my'],true)?$requested:($_COOKIE['tripora_language']??($_SESSION['language']??'en'));
if(!in_array($language,['en','my'],true))$language='en';
$_SESSION['language']=$language;
if(in_array($requested,['en','my'],true))setcookie('tripora_language',$language,['expires'=>time()+31536000,'path'=>'/','secure'=>!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off','httponly'=>true,'samesite'=>'Lax']);
function language(): string {return $GLOBALS['language'];}
function t(string $text): string {
    if(language()!=='my')return $text;
    static $dictionary;
    if($dictionary===null){$dictionary=json_decode(file_get_contents(ROOT.'/config/languages/my.json'),true)??[];if(is_file(ROOT.'/config/myanmar_catalogue.json'))$dictionary+=json_decode(file_get_contents(ROOT.'/config/myanmar_catalogue.json'),true)??[];}
    if(isset($dictionary[$text]))return $dictionary[$text];
    if(str_starts_with($text,'Welcome back, '))return 'ပြန်လည်ကြိုဆိုပါတယ်၊ '.substr($text,14);
    if(str_starts_with($text,'Please enter a valid '))return 'မှန်ကန်သော '.t(rtrim(substr($text,21),'.')).' ထည့်ပါ။';
    if(str_starts_with($text,'Enter a valid '))return 'မှန်ကန်သော '.t(rtrim(substr($text,14),'.')).' ထည့်ပါ။';
    if(preg_match('/^Make time for the everyday details\. Explore (.+) at your own pace\.$/',$text,$m))return t($m[1]).' ကို ကိုယ်ပိုင်စိတ်ကြိုက် အေးအေးဆေးဆေး လေ့လာပါ။';
    if(preg_match('/^(.+) — demonstration listing; no real street address$/',$text,$m))return t($m[1]).' — နမူနာဟိုတယ်၊ တကယ့်လိပ်စာ မဟုတ်ပါ။';
    if(str_contains($text,', ')){ $parts=explode(', ',$text);if(count($parts)===2)return t($parts[0]).'၊ '.t($parts[1]); }
    return $text;
}
function language_url(string $lang): string {
    $args=$_GET;$args['lang']=$lang;
    return ($_SERVER['SCRIPT_NAME']??BASE_PATH.'/customer/home.php').'?'.http_build_query($args);
}
function client_strings(): string {
    $keys=['Gallery photo', 'Replace', 'Remove', 'No additional photos yet.', 'Uploading photos...', 'Photos saved', 'Gallery updated.', 'The gallery could not be updated. Please try again.', 'The request timed out. Check the gallery before retrying.', 'Choose a country or search to view records.', 'Searching...', 'All destinations in this country', 'Could not load records. Please try again.','The email check could not be completed. Please try again.','Send a new code in','Loading record...','Could not load this record. Please try again.','The code could not be sent. Please try again.','Add','Edit','Upload a JPG, PNG or WebP image up to 5 MB.','Checking...','Check availability for your new dates.','Could not check availability. Please try again.','The request timed out. Please try again.','Loading payment details...','Could not load payment details. Please try again.','Screenshot could not be loaded.','Zoom screenshot','Fit screenshot','Connection interrupted. Retrying...','Sending...','Your message could not be sent. Please try again.','Message sent.','Stay saved.','Stay removed from saved stays.','Could not update your saved stays.','Check your connection and try again.','The request timed out. Try saving this stay again.','Save stay','Unsave stay','Saved'];
    $out=[];foreach($keys as $key)$out[$key]=t($key);return json_encode($out,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
}
