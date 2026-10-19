<?php
function api_response(int $status,array $data): never {
    http_response_code($status);header('Content-Type: application/json; charset=utf-8');header('Cache-Control: private, no-store');
    if(isset($data['message']))$data['message']=t($data['message']);
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);exit;
}
function api_user(): array {global $user;if(!$user)api_response(401,['ok'=>false,'message'=>'Please sign in to continue.']);return $user;}
function api_csrf(): void {
    if(!isset($_POST['csrf'],$_SESSION['csrf'])||!hash_equals($_SESSION['csrf'],(string)$_POST['csrf']))api_response(419,['ok'=>false,'message'=>'Your session expired. Please sign in again.']);
}
