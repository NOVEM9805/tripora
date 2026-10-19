<?php
require ROOT.'/includes/admin/config.php';
$sections=['dashboard'=>'Overview','countries'=>'Countries','destinations'=>'Destinations','hotels'=>'Hotels','rooms'=>'Rooms','bookings'=>'Bookings','payments'=>'Payments & refunds','customers'=>'Customers','reviews'=>'Reviews','promotions'=>'Promotions','messages'=>'Messages','settings'=>'Site settings'];
?>
<div class="wrap admin-layout"><aside class="admin-sidebar"><p class="eyebrow"><?=e(t('TRIPORA ADMIN'))?></p><h3><?=e(t('A thoughtful'))?><br><?=e(t('operation.'))?></h3><nav aria-label="<?=e(t('Admin navigation'))?>"><?php foreach($sections as $key=>$label): ?><a class="<?=$key===$section?'active':''?>" href="<?=e(url('admin',['section'=>$key]))?>"><?=e(t($label))?></a><?php endforeach ?></nav></aside><section class="admin-content"><p class="eyebrow"><?=e(t('ADMINISTRATION'))?></p><h1 class="admin-title"><?=e(t($sections[$section]))?><em>.</em></h1>
