<?php
require dirname(__DIR__).'/includes/bootstrap.php';require ROOT.'/includes/api.php';
$admin=api_user();if($admin['role']!=='admin')api_response(403,['ok'=>false,'message'=>'Admin access required.']);
if($_SERVER['REQUEST_METHOD']!=='GET'){header('Allow: GET');api_response(405,['ok'=>false,'message'=>'Invalid request method.']);}
require ROOT.'/includes/admin/catalogue.php';
try{
    $entity=is_string($_GET['entity']??null)?$_GET['entity']:'';
    $result=admin_catalogue($entity,$_GET);
    $filters=['country_id'=>$result['country_id'],'destination_id'=>$result['destination_id'],'q'=>$result['q'],'list_page'=>$result['page']];
    foreach(['country_id','destination_id'] as $key)if(!$filters[$key])unset($filters[$key]);
    $result['html']=admin_entity_rows($entity,$result['rows'],$filters);unset($result['rows']);
    foreach($result['destinations'] as &$destination)$destination['name']=t($destination['name']);unset($destination);
    $result['message']=!$result['country_id']&&$result['q']===''?'Choose a country or search to view records.':(!$result['total']?'No matching records.':'Results updated.');
    api_response(200,['ok'=>true,...$result]);
}catch(DomainException $ex){api_response(422,['ok'=>false,'message'=>$ex->getMessage()]);}
catch(Throwable $ex){api_response(500,['ok'=>false,'message'=>'Could not load records. Please try again.']);}
