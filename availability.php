<?php
require dirname(__DIR__).'/includes/bootstrap.php';require ROOT.'/includes/api.php';
if($_SERVER['REQUEST_METHOD']!=='GET'){header('Allow: GET');api_response(405,['ok'=>false,'message'=>'Use GET to check availability.']);}
try{
 $id=filter_var($_GET['id']??null,FILTER_VALIDATE_INT);$guests=filter_var($_GET['guests']??null,FILTER_VALIDATE_INT);
 if(!$id||!$guests||$guests<1||$guests>12)throw new DomainException('Choose 1 to 12 travelers and a valid hotel.');
 $h=one('SELECT h.* FROM hotels h JOIN destinations d ON d.id=h.destination_id AND d.active=1 JOIN countries c ON c.id=d.country_id AND c.active=1 WHERE h.id=? AND h.active=1',[$id]);
 if(!$h)api_response(404,['ok'=>false,'message'=>'Stay not found.']);
 $in=(string)($_GET['check_in']??'');$out=(string)($_GET['check_out']??'');$nights=dates($in,$out);$goodDates=true;expire_holds();
 $rooms=all('SELECT * FROM rooms WHERE hotel_id=? AND active=1',[$id]);
 ob_start();require ROOT.'/includes/room-list.php';$html=ob_get_clean();
 api_response(200,['ok'=>true,'html'=>$html,'check_in'=>$in,'check_out'=>$out,'guests'=>$guests,'message'=>'Availability updated.']);
}catch(DomainException $ex){api_response(422,['ok'=>false,'message'=>$ex->getMessage()]);}catch(Throwable $ex){api_response(500,['ok'=>false,'message'=>'Could not check availability. Please try again.']);}
