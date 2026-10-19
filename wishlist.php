<?php
require dirname(__DIR__).'/includes/bootstrap.php';
header('Content-Type: application/json; charset=utf-8');header('Cache-Control: no-store');
function respond(int $status,array $body): never {http_response_code($status);if(isset($body['message']))$body['message']=t($body['message']);echo json_encode($body,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);exit;}
if(($_SERVER['REQUEST_METHOD']??'GET')!=='POST'){header('Allow: POST');respond(405,['ok'=>false,'message'=>'Use POST to update saved stays.']);}
if($user&&$user['role']!=='customer')respond(403,['ok'=>false,'message'=>t('Only customers can save stays.')]);
if(!$user)respond(401,['ok'=>false,'message'=>'Your session expired. Please sign in again.']);
if(!isset($_POST['csrf'],$_SESSION['csrf'])||!hash_equals($_SESSION['csrf'],(string)$_POST['csrf']))respond(419,['ok'=>false,'message'=>'Your session expired. Please sign in again.']);
$id=filter_var($_POST['hotel_id']??null,FILTER_VALIDATE_INT);
if(!$id||!in_array($_POST['saved']??null,['0','1'],true))respond(422,['ok'=>false,'message'=>'Choose a valid stay and saved state.']);
$saved=$_POST['saved']==='1';
try{
    if(!one('SELECT id FROM hotels WHERE id=? AND active=1',[$id]))respond(404,['ok'=>false,'message'=>'This stay is unavailable.']);
    if($saved)query('INSERT INTO wishlists (user_id,hotel_id) VALUES (?,?) ON DUPLICATE KEY UPDATE hotel_id=VALUES(hotel_id)',[$user['id'],$id]);
    else query('DELETE FROM wishlists WHERE user_id=? AND hotel_id=?',[$user['id'],$id]);
    respond(200,['ok'=>true,'hotel_id'=>$id,'saved'=>$saved,'message'=>$saved?'Stay saved.':'Stay removed from saved stays.']);
}catch(Throwable $ex){respond(500,['ok'=>false,'message'=>'Could not update this stay. Please try again.']);}
