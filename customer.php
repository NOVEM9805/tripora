<?php
switch($action){
        case 'chat_send':
            $u=require_user();if(!support_ready())throw new DomainException('Run the database upgrade before using chat.');
            throttle('support_send',(string)$u['id'],30,60);
            support_send($u,(int)($_POST['thread_id']??0),text_input('message',12000),(string)($_POST['client_nonce']??''));
            flash('Message sent.');redirect($u['role']==='admin'?'admin':'contact',$u['role']==='admin'?['section'=>'messages','thread_id'=>(int)$_POST['thread_id']]:[]);
        case 'profile':
            $u=require_user();update_profile($u);
            flash('Your profile has been updated.');redirect('profile');
        case 'password_start':
            $u=require_user();unset($_SESSION['password_change']);
            throttle('password_start',$u['id'].'|'.($_SERVER['REMOTE_ADDR']??'local'),5);
            if(!password_verify((string)($_POST['current_password']??''),$u['password_hash']))throw new DomainException('Your current password is incorrect.');
            send_code($u['email'],$u['name'],'change');
            $_SESSION['password_change']=['user_id'=>(int)$u['id'],'email'=>$u['email'],'auth_version'=>(int)$u['auth_version'],'stage'=>'otp','expires'=>time()+600];
            flash('A verification code has been sent.','info');redirect('change');
        case 'password_resend':
            require_user();resend_otp('change');
            flash('A new verification code has been sent.');redirect('change');
        case 'password_verify':
            $u=require_user();$state=change_password_state($u);
            if(!$state||$state['stage']!=='otp')throw new DomainException('Start the password change from your profile.');
            throttle('password_verify',$u['id'].'|'.($_SERVER['REMOTE_ADDR']??'local'),15);
            verify_code($u['email'],'change',otp_input());
            $state['stage']='password';$state['expires']=time()+600;$_SESSION['password_change']=$state;
            session_regenerate_id(true);flash('Code verified. You can now set your new password.');redirect('change');
        case 'password':
            $u=require_user();$state=change_password_state($u);
            if(!$state||$state['stage']!=='password')throw new DomainException('Verify a new code before changing your password.');
            replace_password($u,confirmed_password_input());
            $_SESSION['auth_version']=(int)$u['auth_version']+1;
            unset($_SESSION['password_change'],$_SESSION['reset_grant']);
            session_regenerate_id(true);flash('Password changed.');redirect('profile');
        case 'wishlist':
            $u=require_customer();$id=(int)($_POST['hotel_id']??0);$saved=($_POST['saved']??'1')==='1';
            if(!one('SELECT id FROM hotels WHERE id=? AND active=1',[$id]))throw new DomainException('Stay not found.');
            if($saved)query('INSERT INTO wishlists (user_id,hotel_id) VALUES (?,?) ON DUPLICATE KEY UPDATE hotel_id=VALUES(hotel_id)',[$u['id'],$id]);
            else query('DELETE FROM wishlists WHERE user_id=? AND hotel_id=?',[$u['id'],$id]);
            flash($saved?'Stay saved.':'Stay removed from saved stays.');
            redirect($page,in_array($page,['hotel','booking'],true)?['id'=>(int)($_GET['id']??0)]:[]);
        case 'book':
            $u=require_customer();$id=create_booking((int)$u['id'],$_POST);
            flash('Your room is reserved for 24 hours. Submit payment proof to complete your booking.');redirect('booking',['id'=>$id]);
        case 'cancel':
            $u=require_customer();$id=(int)($_POST['booking_id']??0);
            cancel_booking($id,(int)$u['id']);flash('Booking cancelled. Verified payments are marked for a manual refund.');redirect('booking',['id'=>$id]);
        case 'payment':
            $u=require_customer();submit_payment((int)$u['id'],$_POST);
            flash('Payment proof received. The administrator will review it within the 48-hour hold.');redirect('booking',['id'=>(int)$_POST['booking_id']]);
        case 'review':
            $u=require_customer();$id=(int)($_POST['booking_id']??0);
            $b=one("SELECT b.*,r.hotel_id FROM bookings b JOIN rooms r ON r.id=b.room_id WHERE b.id=? AND b.user_id=? AND b.status='completed'",[$id,$u['id']]);
            $rating=(int)($_POST['rating']??0);
            if(!$b||$rating<1||$rating>5)throw new DomainException('Only completed stays can be reviewed. Select a rating from 1 to 5.');
            query('INSERT INTO reviews (booking_id,user_id,hotel_id,rating,body) VALUES (?,?,?,?,?)',[$id,$u['id'],$b['hotel_id'],$rating,text_input('body',2000)]);
            flash('Thank you for sharing your stay.');redirect('booking',['id'=>$id]);
        case 'contact':
            if($user&&$user['role']==='admin')throw new DomainException('Use the administrator Messages page to reply to customers.');
            throttle('contact',$_SERVER['REMOTE_ADDR']??'local',5);
            query('INSERT INTO contacts (name,email,message) VALUES (?,?,?)',[text_input('name',120),valid_email(text_input('email',190)),text_input('message',3000)]);
            flash('Your message has been sent to the Tripora team.');redirect('contact');
default: throw new DomainException('Unknown form action.');
}
