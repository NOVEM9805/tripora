<?php
require dirname(__DIR__).'/includes/bootstrap.php';require ROOT.'/includes/api.php';
$admin=api_user();if($admin['role']!=='admin')api_response(403,['ok'=>false,'message'=>'Admin access required.']);
$method=$_SERVER['REQUEST_METHOD'];
if(!in_array($method,['GET','POST'],true)){header('Allow: GET, POST');api_response(405,['ok'=>false,'message'=>'Invalid request method.']);}
if($method==='POST')api_csrf();
$input=$method==='POST'?$_POST:$_GET;
$id=filter_var($input['destination_id']??null,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);
if(!$id)api_response(422,['ok'=>false,'message'=>'Select a valid destination.']);
$newPath=null;
try{
    if(!gallery_ready())throw new DomainException('Run database/upgrade_v5.sql to enable unlimited gallery photos.');
    if(!one('SELECT id FROM destinations WHERE id=?',[$id]))api_response(404,['ok'=>false,'message'=>'Record not found.']);
    if($method==='GET')api_response(200,['ok'=>true,'images'=>gallery_items($id)]);
    $mode=is_string($input['mode']??null)?$input['mode']:'';
    if(!in_array($mode,['add','replace','remove'],true))throw new DomainException('Invalid gallery action.');
    $photoId=0;
    if($mode!=='add'){
        $photoId=filter_var($input['photo_id']??null,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);
        if(!$photoId)throw new DomainException('Choose a valid gallery photo.');
    }
    $db->beginTransaction();
    one('SELECT id FROM destinations WHERE id=? FOR UPDATE',[$id]);
    if($mode!=='add'&&!one('SELECT id FROM destination_images WHERE id=? AND destination_id=? FOR UPDATE',[$photoId,$id]))throw new DomainException('This photo does not belong to this destination.');
    if($mode!=='remove')$newPath=save_upload('image');
    if($mode==='add'){
        $position=(int)(one('SELECT COALESCE(MAX(position),0)+1 AS next_position FROM destination_images WHERE destination_id=?',[$id])['next_position']);
        query('INSERT INTO destination_images(destination_id,image,position) VALUES(?,?,?)',[$id,$newPath,$position]);
    }elseif($mode==='replace')query('UPDATE destination_images SET image=? WHERE id=? AND destination_id=?',[$newPath,$photoId,$id]);
    else query('DELETE FROM destination_images WHERE id=? AND destination_id=?',[$photoId,$id]);
    audit('gallery_'.$mode,(string)$id);$db->commit();$newPath=null;
    api_response(200,['ok'=>true,'message'=>'Gallery updated.','images'=>gallery_items($id)]);
}catch(Throwable $ex){
    if($db->inTransaction())$db->rollBack();
    if($newPath&&preg_match('~^public/uploads/[a-f0-9]{32}\.(jpg|png|webp)$~D',$newPath))@unlink(ROOT.'/'.$newPath);
    api_response($ex instanceof DomainException?422:500,['ok'=>false,'message'=>$ex instanceof DomainException?$ex->getMessage():'The gallery could not be updated. Please try again.']);
}
