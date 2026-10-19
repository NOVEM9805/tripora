<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='saved';
require ROOT.'/includes/page-start.php';
 ?>
<section class="wrap section"><p class="eyebrow"><?=e(t('KEEP A LITTLE INSPIRATION'))?></p><h1><?=e(t('Your saved'))?> <em><?=e(t('stays.'))?></em></h1><?php $hotels=hotel_list('h.id IN (SELECT hotel_id FROM wishlists WHERE user_id=?)',[$user['id']],90); ?><div class="cards" data-saved-list><?php hotel_cards($hotels); ?></div><?php if(!$hotels): ?><div class="empty"><h3><?=e(t('Somewhere is waiting.'))?></h3><p><?=e(t('Tap a heart on a stay to save it here.'))?></p><a class="button" href="<?=e(url('stays'))?>"><?=e(t('Explore stays ↗'))?></a></div><?php endif ?></section>

<?php require ROOT.'/includes/page-end.php'; ?>
