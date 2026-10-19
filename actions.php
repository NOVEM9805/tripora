<?php
if(($_SERVER['REQUEST_METHOD']??'GET')!=='POST')return;
check_csrf();
$action=(string)($_POST['action']??'');$back=$page;$args=[];
try{
 if(str_starts_with($action,'admin_') && $action!=='admin_login' && $action!=='admin_logout'){require_admin();require ROOT.'/includes/actions/admin.php';}
 elseif(in_array($action,["register", "verify", "resend", "login", "logout", "forgot", "reset", "reset_verify", "reset_resend", "setup"],true)||in_array($action,['admin_login','admin_logout'],true)){require ROOT.'/includes/actions/auth.php';}
 else require ROOT.'/includes/actions/customer.php';
} catch(DomainException $ex) {
    if($db->inTransaction())$db->rollBack();
    flash($ex->getMessage(),'error');
} catch(PDOException $ex) {
    if($db->inTransaction())$db->rollBack();
    flash((string)$ex->getCode()==='23000'?'This record already exists, or is linked to another record. Use deactivation to keep booking history.':'The update could not be saved. Please try again.','error');
} catch(Throwable $ex) {
    if($db->inTransaction())$db->rollBack();
    flash('The request could not be completed. Please check your setup and try again.','error');
}
if(in_array($back,['hotel','booking'],true))$args=['id'=>(int)($_GET['id']??0)];
if($back==='admin'){
    $args=['section'=>$section];
    if(in_array($section,['destinations','hotels'],true)){
        foreach(['country_id','destination_id','list_page'] as $key){$value=filter_var($_GET[$key]??null,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);if($value)$args[$key]=$value;}
        if(is_string($_GET['q']??null)&&strlen($_GET['q'])<=400)$args['q']=$_GET['q'];
    }
}
if($action==='register' && isset($_SESSION['verify_email']))$back='verify';
redirect($back,$args);
