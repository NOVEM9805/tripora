<?php
require dirname(__DIR__).'/includes/bootstrap.php';
if(!$user){http_response_code(401);exit;}
$name=(string)($user['profile_image']??'');
if(!preg_match('/^[a-f0-9]{32}\.(jpg|png|webp)$/D',$name)||!is_file(ROOT.'/storage/private/'.$name)){http_response_code(404);exit;}
$path=ROOT.'/storage/private/'.$name;
header('Content-Type: '.(new finfo(FILEINFO_MIME_TYPE))->file($path));
header('Cache-Control: private, no-store');header('Content-Disposition: inline');
header('Content-Length: '.filesize($path));readfile($path);
