<?php
require dirname(__DIR__).'/includes/bootstrap.php';require ROOT.'/includes/api.php';
$u=api_user();if($_SERVER['REQUEST_METHOD']!=='GET'){header('Allow: GET');api_response(405,['ok'=>false,'message'=>'Invalid request method.']);}
try{
 $p=one('SELECT p.*,b.reference,b.user_id,b.guest_name,b.check_in,b.check_out,h.name hotel_name,r.name room_name FROM payments p JOIN bookings b ON b.id=p.booking_id JOIN rooms r ON r.id=b.room_id JOIN hotels h ON h.id=r.hotel_id WHERE p.id=?',[(int)($_GET['id']??0)]);
 if(!$p||($u['role']!=='admin'&&(int)$p['user_id']!==(int)$u['id']))api_response(404,['ok'=>false,'message'=>'Payment not found.']);
 api_response(200,['ok'=>true,'payment'=>['reference'=>$p['reference'],'customer'=>$p['guest_name'],'hotel'=>$p['hotel_name'],'room'=>t($p['room_name']),'dates'=>$p['check_in'].' → '.$p['check_out'],'method'=>t(['bank'=>'Bank transfer','kpay'=>'KPay','wave'=>'Wave Money'][$p['method']]),'amount'=>money($p['amount']),'transaction'=>$p['transaction_ref'],'status'=>t(str_replace('_',' ',$p['status'])),'note'=>$p['admin_note'],'submitted'=>$p['created_at'].' UTC','reviewed'=>$p['reviewed_at']?$p['reviewed_at'].' UTC':t('Not reviewed yet'),'image'=>url('proof',['id'=>$p['id']])]]);
}catch(Throwable $ex){api_response(500,['ok'=>false,'message'=>'Could not load payment details. Please try again.']);}
