<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='trips';
require ROOT.'/includes/page-start.php';
 ?>
<section class="wrap section"><p class="eyebrow"><?=e(t('THE NEXT CHAPTER'))?></p><h1><?=e(t('Your'))?> <em><?=e(t('journeys.'))?></em></h1><?php $trips=all('SELECT b.*,r.name room_name,h.name hotel_name,h.image FROM bookings b JOIN rooms r ON r.id=b.room_id JOIN hotels h ON h.id=r.hotel_id WHERE b.user_id=? ORDER BY b.id DESC',[$user['id']]);foreach($trips as $b): ?><article class="trip-card"><img src="<?=e(photo($b['image']))?>" alt="<?=e($b['hotel_name'])?>"><div><span class="eyebrow"><?=e($b['reference'])?></span><h3><?=e($b['hotel_name'])?></h3><p><?=e(t($b['room_name']))?> · <?=e($b['check_in'])?> → <?=e($b['check_out'])?></p><span class="badge <?=e($b['status'])?>"><?=e(t(str_replace('_',' ',$b['status'])))?></span></div><div><strong><?=money($b['total'])?></strong><p><a class="button outline" href="<?=e(url('booking',['id'=>$b['id']]))?>"><?=e(t('View booking ↗'))?></a></p></div></article><?php endforeach;if(!$trips): ?><div class="empty"><h3><?=e(t('Your story starts here.'))?></h3><p><?=e(t('Choose a stay and make your first booking.'))?></p><a class="button" href="<?=e(url('stays'))?>"><?=e(t('Find a stay ↗'))?></a></div><?php endif ?></section>

<?php require ROOT.'/includes/page-end.php'; ?>
