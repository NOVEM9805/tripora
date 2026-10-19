<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='explore';
require ROOT.'/includes/page-start.php';
 ?>
<section class="wrap section"><p class="eyebrow"><?=e(t('CHOOSE YOUR NEXT CHAPTER'))?></p><h1><?=e(t('The world is'))?><br><em><?=e(t('calling.'))?></em></h1><p class="lead"><?=e(t('Six countries. Thirty destinations. Start somewhere new.'))?></p><div class="cards"><?php foreach(all('SELECT * FROM countries WHERE active=1') as $c): ?><a class="stay-card" href="<?=e(url('country',['id'=>$c['id']]))?>"><img class="wide-photo" src="<?=e(photo($c['image']))?>" alt="<?=e(t($c['name']))?>"><div class="card-body"><h3><?=e(t($c['name']))?></h3><p><?=e(t($c['description']))?></p><span class="text-link"><?=e(t('Explore country ↗'))?></span></div></a><?php endforeach ?></div></section>

<?php require ROOT.'/includes/page-end.php'; ?>
