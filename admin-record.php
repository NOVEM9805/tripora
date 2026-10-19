<?php
require dirname(__DIR__).'/includes/bootstrap.php';require ROOT.'/includes/api.php';
$u=api_user();if($u['role']!=='admin')api_response(403,['ok'=>false,'message'=>'Admin access required.']);
if($_SERVER['REQUEST_METHOD']!=='GET'){header('Allow: GET');api_response(405,['ok'=>false,'message'=>'Invalid request method.']);}
require ROOT.'/includes/admin/config.php';
$entity=is_string($_GET['entity']??null)?$_GET['entity']:'';
if(!isset($entities[$entity]))api_response(422,['ok'=>false,'message'=>'Unknown record type.']);
$id=filter_var($_GET['id']??null,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);
if(!$id)api_response(422,['ok'=>false,'message'=>'Select a valid record.']);
try{
    $record=one("SELECT * FROM $entity WHERE id=?",[$id]);
    if(!$record)api_response(404,['ok'=>false,'message'=>'Record not found.']);
    $record['photo_urls']=[];
    foreach($entities[$entity] as $key=>$type)if($type==='image')$record['photo_urls'][$key]=!empty($record[$key])?photo($record[$key]):'';
    if($entity==='destinations')$record['gallery']=gallery_items((int)$record['id']);
    api_response(200,['ok'=>true,'record'=>$record]);
}catch(Throwable $ex){api_response(500,['ok'=>false,'message'=>'Could not load this record. Please try again.']);}
