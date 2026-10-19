<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='admin';
$section='dashboard';
require ROOT.'/includes/page-start.php';
 ?>
<div class="stats-grid"><?php foreach(['Countries'=>"SELECT COUNT(*) n FROM countries",'Destinations'=>"SELECT COUNT(*) n FROM destinations",'Hotels'=>"SELECT COUNT(*) n FROM hotels",'Customers'=>"SELECT COUNT(*) n FROM users WHERE role='customer'",'Bookings'=>"SELECT COUNT(*) n FROM bookings",'Awaiting review'=>"SELECT COUNT(*) n FROM payments WHERE status='submitted'"] as $label=>$sql): ?><div class="panel"><span class="eyebrow"><?=e(t($label))?></span><strong class="stat-number"><?=e(one($sql)['n'])?></strong></div><?php endforeach ?></div><div class="panel space-top"><h3><?=e(t('Verified revenue'))?></h3><p class="stat-number"><?=money(one("SELECT COALESCE(SUM(amount),0) n FROM payments WHERE status='verified'")['n'])?></p><p class="muted"><?=e(t('USD · verified payments only. Refund due/refunded payments are excluded.'))?></p></div><div class="panel space-top"><h3><?=e(t('Keep the details in order'))?></h3><p><?=e(t('Review submitted payments before their 48-hour holds expire. Expired submissions move to refunds. Complete confirmed stays after check-out so customers can leave reviews.'))?></p><div class="button-row"><a class="button" href="<?=e(url('admin',['section'=>'payments']))?>"><?=e(t('Review payments ↗'))?></a><a class="button outline" href="<?=e(url('admin',['section'=>'bookings']))?>"><?=e(t('Manage bookings'))?></a></div></div>

<?php require ROOT.'/includes/page-end.php'; ?>
