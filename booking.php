<?php
declare(strict_types=1);
function dates(string $in, string $out): int {
    $a=DateTimeImmutable::createFromFormat('!Y-m-d',$in);
    $b=DateTimeImmutable::createFromFormat('!Y-m-d',$out);
    if(!$a||!$b||$a->format('Y-m-d')!==$in||$b->format('Y-m-d')!==$out) throw new DomainException('Choose valid check-in and check-out dates.');
    $n=(int)$a->diff($b)->format('%r%a');
    if($in<gmdate('Y-m-d') || $in>gmdate('Y-m-d',strtotime('+1 year')) || $n<1 || $n>30) throw new DomainException('Choose a future stay of 1–30 nights, within one year.');
    return $n;
}
function occupancy_peak(array $bookings, string $in, string $out): int {
    $events=[];
    foreach($bookings as $b){
        $start=max($in,$b['check_in']);$end=min($out,$b['check_out']);
        if($start>=$end)continue;
        $events[$start]=($events[$start]??0)+1;
        $events[$end]=($events[$end]??0)-1;
    }
    ksort($events);$current=0;$peak=0;
    foreach($events as $delta){$current+=$delta;$peak=max($peak,$current);}
    return $peak;
}
function available(int $room, string $in, string $out, ?int $exclude=null): int {
    $r=one('SELECT inventory FROM rooms WHERE id=? AND active=1',[$room]);
    if(!$r)return 0;
    $bookings=all("SELECT check_in,check_out FROM bookings WHERE room_id=? AND check_in<? AND check_out>? AND (status IN ('confirmed','completed') OR (status IN ('pending_payment','awaiting_review') AND expires_at>UTC_TIMESTAMP())) AND id<>?",[$room,$out,$in,$exclude??0]);
    return max(0,(int)$r['inventory']-occupancy_peak($bookings,$in,$out));
}
function available_hotel_prices(string $in,string $out,int $guests): array {
    $rooms=all('SELECT id,hotel_id,price,inventory FROM rooms WHERE active=1 AND capacity>=?',[$guests]);
    $byRoom=[];
    foreach(all("SELECT room_id,check_in,check_out FROM bookings WHERE check_in<? AND check_out>? AND (status IN ('confirmed','completed') OR (status IN ('pending_payment','awaiting_review') AND expires_at>UTC_TIMESTAMP()))",[$out,$in]) as $b)$byRoom[$b['room_id']][]=$b;
    $prices=[];
    foreach($rooms as $r){
        if((int)$r['inventory']<=occupancy_peak($byRoom[$r['id']]??[],$in,$out))continue;
        $prices[$r['hotel_id']]=min($prices[$r['hotel_id']]??PHP_FLOAT_MAX,(float)$r['price']);
    }
    return $prices;
}
function create_booking(int $uid, array $p): int {
    global $db;
    $in=(string)($p['check_in']??'');$out=(string)($p['check_out']??'');$nights=dates($in,$out);
    $guests=filter_var($p['guests']??0,FILTER_VALIDATE_INT);
    $name=trim((string)($p['guest_name']??''));$phone=trim((string)($p['phone']??''));
    if(strlen($name)<2||strlen($name)>120||strlen($phone)<6||strlen($phone)>40) throw new DomainException('Enter your guest name and a valid phone number.');
    $db->beginTransaction();
    try {
        $r=one('SELECT r.*,h.active hotel_active,d.active destination_active,c.active country_active FROM rooms r JOIN hotels h ON h.id=r.hotel_id JOIN destinations d ON d.id=h.destination_id JOIN countries c ON c.id=d.country_id WHERE r.id=? FOR UPDATE',[(int)($p['room_id']??0)]);
        if(!$r||!$r['active']||!$r['hotel_active']||!$r['destination_active']||!$r['country_active']) throw new DomainException('This room is unavailable.');
        if(!$guests||$guests<1||$guests>(int)$r['capacity']) throw new DomainException('The guest count exceeds this room’s capacity.');
        if(available((int)$r['id'],$in,$out)<1) throw new DomainException('This room is sold out for those dates. Choose another room or dates.');
        $subtotal=round((float)$r['price']*$nights,2);$discount=0;$promo=null;
        $code=strtoupper(trim((string)($p['promo_code']??'')));
        if($code!=='') {
            $promo=one('SELECT * FROM promotions WHERE code=? AND active=1 AND starts_on<=UTC_DATE() AND ends_on>=UTC_DATE() FOR UPDATE',[$code]);
            if(!$promo)throw new DomainException('That promotion is unavailable.');
            $used=one("SELECT COUNT(*) n FROM bookings WHERE promotion_id=? AND status NOT IN ('cancelled','expired') AND (status IN ('confirmed','completed') OR expires_at>UTC_TIMESTAMP())",[$promo['id']]);
            if((int)$used['n']>=(int)$promo['usage_limit'])throw new DomainException('That promotion has reached its booking limit.');
            $discount=min($subtotal,round($subtotal*(float)$promo['percent_off']/100,2));
        }
        $ref='TRP-'.gmdate('ymd').'-'.strtoupper(bin2hex(random_bytes(4)));
        query("INSERT INTO bookings (reference,user_id,room_id,guest_name,phone,guests,check_in,check_out,nights,nightly_price,subtotal,discount,total,promotion_id,status,expires_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,'pending_payment',DATE_ADD(UTC_TIMESTAMP(),INTERVAL 24 HOUR))",[$ref,$uid,$r['id'],$name,$phone,$guests,$in,$out,$nights,$r['price'],$subtotal,$discount,$subtotal-$discount,$promo['id']??null]);
        $id=(int)$db->lastInsertId();$db->commit();return $id;
    }catch(Throwable $ex){if($db->inTransaction())$db->rollBack();throw $ex;}
}
function cancel_booking(int $id,int $uid): void {
    global $db;
    $db->beginTransaction();
    try {
        $b=one('SELECT * FROM bookings WHERE id=? AND user_id=? FOR UPDATE',[$id,$uid]);
        if(!$b||!in_array($b['status'],['pending_payment','awaiting_review','confirmed'],true))throw new DomainException('This booking cannot be cancelled.');
        if($b['check_in']<=gmdate('Y-m-d'))throw new DomainException('Contact the administrator to cancel a stay that has started.');
        query("UPDATE bookings SET status='cancelled',expires_at=NULL WHERE id=?",[$id]);
        query("UPDATE payments SET status='refund_due' WHERE booking_id=? AND status IN ('submitted','verified')",[$id]);
        $db->commit();
    }catch(Throwable $ex){if($db->inTransaction())$db->rollBack();throw $ex;}
}
function submit_payment(int $uid, array $p): void {
    global $db;
    $id=(int)($p['booking_id']??0);$method=(string)($p['method']??'');
    if(!in_array($method,['bank','kpay','wave'],true))throw new DomainException('Select a payment method.');
    $reference=trim((string)($p['transaction_ref']??''));
    if(strlen($reference)<4||strlen($reference)>120)throw new DomainException('Enter the payment transaction reference.');
    $db->beginTransaction();$file=null;
    try{
        $b=one('SELECT * FROM bookings WHERE id=? AND user_id=? FOR UPDATE',[$id,$uid]);
        if(!$b||$b['status']!=='pending_payment'||strtotime($b['expires_at'])<=time())throw new DomainException('This booking is no longer awaiting payment.');
        if(one('SELECT id FROM payments WHERE method=? AND transaction_ref=? AND booking_id<>?',[$method,$reference,$id]))throw new DomainException('This transaction reference is already attached to another booking.');
        $file=save_upload('proof',true);
        query("INSERT INTO payments (booking_id,method,transaction_ref,amount,proof_path,status) VALUES (?,?,?,?,?,'submitted')",[$id,$method,$reference,$b['total'],$file]);
        query("UPDATE bookings SET status='awaiting_review',expires_at=DATE_ADD(UTC_TIMESTAMP(),INTERVAL 48 HOUR) WHERE id=?",[$id]);
        $db->commit();
    }catch(Throwable $ex){if($db->inTransaction())$db->rollBack();if($file)@unlink(ROOT.'/storage/private/'.$file);throw $ex;}
}
function review_payment(int $id,string $decision,string $note): void {
    global $db,$user;
    if(!in_array($decision,['verify','reject','refunded'],true))throw new DomainException('Invalid payment action.');
    $db->beginTransaction();
    try{
        // Lock booking before payment, matching the customer cancellation order.
        $candidate=one('SELECT booking_id FROM payments WHERE id=?',[$id]);
        if(!$candidate)throw new DomainException('Payment not found.');
        $b=one('SELECT * FROM bookings WHERE id=? FOR UPDATE',[$candidate['booking_id']]);
        $p=one('SELECT * FROM payments WHERE id=? FOR UPDATE',[$id]);
        if($decision==='refunded'){
            if($p['status']!=='refund_due')throw new DomainException('This payment is not awaiting a refund.');
            query("UPDATE payments SET status='refunded',admin_note=?,reviewed_by=?,reviewed_at=UTC_TIMESTAMP() WHERE id=?",[$note,$user['id'],$id]);
        }else{
            if($p['status']!=='submitted'||$b['status']!=='awaiting_review'||strtotime($b['expires_at'])<=time())throw new DomainException('This payment is not awaiting review. An expired payment needs a refund.');
            if($decision==='verify'){
                query("UPDATE payments SET status='verified',admin_note=?,reviewed_by=?,reviewed_at=UTC_TIMESTAMP() WHERE id=?",[$note,$user['id'],$id]);
                query("UPDATE bookings SET status='confirmed',expires_at=NULL WHERE id=?",[$b['id']]);
            }else{
                query("UPDATE payments SET status='rejected',admin_note=?,reviewed_by=?,reviewed_at=UTC_TIMESTAMP() WHERE id=?",[$note,$user['id'],$id]);
                query("UPDATE bookings SET status='pending_payment',expires_at=DATE_ADD(UTC_TIMESTAMP(),INTERVAL 24 HOUR) WHERE id=?",[$b['id']]);
            }
        }
        audit('payment_'.$decision,(string)$id);$db->commit();
    }catch(Throwable $ex){if($db->inTransaction())$db->rollBack();throw $ex;}
}
function expire_holds(): void {
    global $db;
    // Use booking row locks so expiry cannot race with confirmation.
    $db->beginTransaction();
    try{
        $items=all("SELECT id FROM bookings WHERE status IN ('pending_payment','awaiting_review') AND expires_at<=UTC_TIMESTAMP() ORDER BY id FOR UPDATE");
        foreach($items as $b){
            query("UPDATE bookings SET status='expired' WHERE id=?",[$b['id']]);
            query("UPDATE payments SET status='refund_due' WHERE booking_id=? AND status='submitted'",[$b['id']]);
        }
        $db->commit();
    }catch(Throwable $ex){if($db->inTransaction())$db->rollBack();throw $ex;}
}
