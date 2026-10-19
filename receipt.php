<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$u=require_user();$p=one('SELECT p.*,b.user_id FROM payments p JOIN bookings b ON b.id=p.booking_id WHERE p.id=?',[(int)($_GET['id']??0)]);
if(!$p||($u['role']!=='admin'&&(int)$p['user_id']!==(int)$u['id'])){http_response_code(404);exit('Image not found.');}
$name=$p['proof_path'];if(!preg_match('/^[a-f0-9]{32}\.(jpg|png|webp)$/D',$name)){http_response_code(404);exit;}
$file=ROOT.'/storage/private/'.$name;if(!is_file($file)){http_response_code(404);exit;}
header('Cache-Control: private, no-store');header('Content-Type: '.(new finfo(FILEINFO_MIME_TYPE))->file($file));readfile($file);
