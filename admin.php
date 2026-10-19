<?php
require ROOT.'/includes/admin/config.php';

switch($action){
 case 'admin_save':
    $entity=(string)($_POST['entity']??'');$fields=$entities[$entity]??null;
    if(!$fields)throw new DomainException('Unknown record type.');
    $id=(int)($_POST['id']??0);$old=$id?one("SELECT * FROM $entity WHERE id=?",[$id]):null;
    if($id&&!$old)throw new DomainException('Record not found.');
    $data=[];$imageFields=[];
    foreach($fields as $key=>$type){
        if($type==='bool'){$data[$key]=isset($_POST[$key])?1:0;continue;}
        if($type==='image'){
            $data[$key]=$old[$key]??($key==='image'?'public/images/hotel.jpg':'');
            if($key!=='image'&&isset($_POST['remove_'.$key]))$data[$key]='';
            $imageFields[]=$key;
            continue;
        }
        $v=text_input($key,in_array($type,['textarea'],true)?4000:190);
        if(in_array($type,['countries','destinations','hotels'],true)){
            if(!preg_match('/^[0-9]+$/D',(string)$v)||!one("SELECT id FROM $type WHERE id=?",[(int)$v]))throw new DomainException('Choose a valid parent record.');
            $v=(int)$v;
        }
        if($type==='number'||$type==='decimal'){
            if(!is_numeric($v)||(float)$v<0||(float)$v>1000000||($type==='number'&&(!preg_match('/^[0-9]+$/D',(string)$v))))throw new DomainException('Enter a valid '.$key.'.');
            $v=$type==='number'?(int)$v:round((float)$v,2);
        }
        if($type==='date'){
            $d=DateTimeImmutable::createFromFormat('!Y-m-d',$v);
            if(!$d||$d->format('Y-m-d')!==$v)throw new DomainException('Choose a valid date.');
        }
        $data[$key]=$v;
    }
    if($entity==='hotels'&&($data['stars']<1||$data['stars']>5))throw new DomainException('Hotel stars must be 1–5.');
    if($entity==='rooms'&&($data['capacity']<1||$data['capacity']>12||$data['inventory']<1||$data['inventory']>1000||$data['price']<=0))throw new DomainException('Room price, inventory and capacity must be positive. Capacity is limited to 12.');
    if($entity==='promotions'){
        $data['code']=strtoupper($data['code']);
        if(!preg_match('/^[A-Z0-9_-]{3,30}$/D',$data['code'])||$data['percent_off']<=0||$data['percent_off']>80||$data['usage_limit']<1||$data['ends_on']<$data['starts_on'])throw new DomainException('Use a valid promotion code, 1–80% discount and a valid date range.');
    }
    $newFiles=[];
    try{
    foreach($imageFields as $key){
        if(isset($_FILES[$key])&&$_FILES[$key]['error']!==UPLOAD_ERR_NO_FILE){$data[$key]=save_upload($key);$newFiles[]=$data[$key];}
    }
    $db->beginTransaction();
    if($entity==='rooms'&&$old){
        $current=one('SELECT * FROM rooms WHERE id=? FOR UPDATE',[$id]);
        $has=one("SELECT id FROM bookings WHERE room_id=? AND check_out>UTC_DATE() AND (status='confirmed' OR (status IN ('pending_payment','awaiting_review') AND expires_at>UTC_TIMESTAMP())) LIMIT 1",[$id]);
        if($has&&($data['inventory']<(int)$current['inventory']||$data['capacity']<(int)$current['capacity']||$data['hotel_id']!=(int)$current['hotel_id']))throw new DomainException('This room has upcoming reservations. Do not reduce capacity/inventory or move it to another hotel.');
    }
    $keys=array_keys($data);$vals=array_values($data);
    if($id){$set=implode(',',array_map(fn($k)=>"$k=?",$keys));query("UPDATE $entity SET $set WHERE id=?",[...$vals,$id]);}
    else {query("INSERT INTO $entity (".implode(',',$keys).') VALUES ('.implode(',',array_fill(0,count($keys),'?')).')',$vals);$id=(int)$db->lastInsertId();}
    audit('save_'.$entity,(string)$id);$db->commit();
    }catch(Throwable $ex){
        if($db->inTransaction())$db->rollBack();
        foreach($newFiles as $path)if(preg_match('~^public/uploads/[a-f0-9]{32}\.(jpg|png|webp)$~D',$path))@unlink(ROOT.'/'.$path);
        throw $ex;
    }
    $return=['section'=>$entity];
    if($entity==='destinations')$return['country_id']=$data['country_id'];
    if($entity==='hotels'){$return['destination_id']=$data['destination_id'];$return['country_id']=one('SELECT country_id FROM destinations WHERE id=?',[$data['destination_id']])['country_id'];}
    flash('Record saved.');redirect('admin',$return);
 case 'admin_delete':
    $entity=(string)($_POST['entity']??'');
    if(!isset($entities[$entity]))throw new DomainException('Unknown record type.');
    query("DELETE FROM $entity WHERE id=?",[(int)($_POST['id']??0)]);
    audit('delete_'.$entity,(string)($_POST['id']??0));flash('Record deleted.');
    $return=['section'=>$entity];
    if(in_array($entity,['destinations','hotels'],true)){
        foreach(['country_id','destination_id','list_page'] as $key){$value=filter_var($_POST['return_'.$key]??null,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);if($value)$return[$key]=$value;}
        if(is_string($_POST['return_q']??null)&&strlen($_POST['return_q'])<=400)$return['q']=$_POST['return_q'];
    }
    redirect('admin',$return);
 case 'admin_payment':
    review_payment((int)($_POST['id']??0),(string)($_POST['decision']??''),text_input('note',500,false));
    flash('Payment review saved.');redirect('admin',['section'=>'payments']);
 case 'admin_booking':
    $id=(int)($_POST['id']??0);$decision=(string)($_POST['decision']??'');
    $b=one('SELECT * FROM bookings WHERE id=?',[$id]);if(!$b)throw new DomainException('Booking not found.');
    if($decision==='cancel'){
        $db->beginTransaction();$b=one('SELECT * FROM bookings WHERE id=? FOR UPDATE',[$id]);
        if(!in_array($b['status'],['pending_payment','awaiting_review','confirmed'],true))throw new DomainException('This booking cannot be cancelled.');
        query("UPDATE bookings SET status='cancelled',expires_at=NULL WHERE id=?",[$id]);
        query("UPDATE payments SET status='refund_due' WHERE booking_id=? AND status IN ('submitted','verified')",[$id]);$db->commit();
    }elseif($decision==='complete'){
        if($b['check_out']>gmdate('Y-m-d'))throw new DomainException('Complete a stay after its check-out date.');
        $st=query("UPDATE bookings SET status='completed' WHERE id=? AND status='confirmed'",[$id]);
        if($st->rowCount()!==1)throw new DomainException('Only confirmed bookings can be completed.');
    }else throw new DomainException('Invalid booking action.');
    audit('booking_'.$decision,(string)$id);flash('Booking updated.');redirect('admin',['section'=>'bookings']);
 case 'admin_user':
    $id=(int)($_POST['id']??0);
    query("UPDATE users SET active=1-active WHERE id=? AND role='customer'",[$id]);audit('customer_toggle',(string)$id);
    flash('Customer status updated.');redirect('admin',['section'=>'customers']);
 case 'admin_review':
    query('UPDATE reviews SET visible=1-visible WHERE id=?',[(int)($_POST['id']??0)]);flash('Review visibility updated.');redirect('admin',['section'=>'reviews']);
 case 'admin_contact':
    query("UPDATE contacts SET status='resolved' WHERE id=?",[(int)($_POST['id']??0)]);flash('Message marked resolved.');redirect('admin',['section'=>'messages']);
 case 'admin_settings':
    foreach(['site_tagline','contact_email','contact_phone','payment_instructions','bank_account','kpay_account','wave_account'] as $key){
        $value=text_input($key,2000,false);
        if($key==='contact_email'&&$value!=='')$value=valid_email($value);
        query('UPDATE settings SET setting_value=? WHERE setting_key=?',[$value,$key]);
    }audit('settings','Updated site settings');flash('Settings saved.');redirect('admin',['section'=>'settings']);
 default:throw new DomainException('Unknown administrator action.');
}
