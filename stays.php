<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='stays';
require ROOT.'/includes/page-start.php';

$q=trim((string)($_GET['q']??''));$conditions=['1'];$params=[];$valid=true;
if($q!==''){$conditions[]='(h.name LIKE ? OR d.name LIKE ? OR c.name LIKE ?)';$params=["%$q%","%$q%","%$q%"];} 
if(isset($_GET['check_in'])||isset($_GET['check_out'])){
 try{dates($in,$out);$availablePrices=available_hotel_prices($in,$out,$guests);}catch(DomainException $ex){$valid=false;$dateError=$ex->getMessage();}
}
$hotels=$valid?hotel_list(implode(' AND ',$conditions),$params,90):[];
if(isset($availablePrices)){
 $hotels=array_values(array_filter($hotels,fn($h)=>isset($availablePrices[$h['id']])));
 foreach($hotels as &$result)$result['price']=$availablePrices[$result['id']];unset($result);
}
?>
<section class="wrap section"><p class="eyebrow"><?=e(t('YOUR NEXT GOOD STAY'))?></p><h1><?=e(t('Make yourself'))?><br><em><?=e(t('somewhere.'))?></em></h1><form class="search-bar search-inline" method="get" action="<?=e(url('stays'))?>"><label><span><?=e(t('DESTINATION'))?></span><input name="q" value="<?=e($q)?>" placeholder="<?=e(t('Country, city or hotel'))?>"></label><label><span><?=e(t('CHECK IN'))?></span><input type="date" name="check_in" value="<?=e($in)?>" min="<?=$today?>" required></label><label><span><?=e(t('CHECK OUT'))?></span><input type="date" name="check_out" value="<?=e($out)?>" min="<?=$tomorrow?>" required></label><label><span><?=e(t('TRAVELERS'))?></span><select name="guests"><?php for($g=1;$g<=12;$g++): ?><option value="<?=$g?>" <?=$guests===$g?'selected':''?>><?=$g?> <?=e(t('guest'))?><?=$g>1?'s':''?></option><?php endfor ?></select></label><button class="button"><?=e(t('Search ↗'))?></button></form><p class="muted"><?=count($hotels)?> <?=e(t('stays found. Prices are demo prices in USD.'))?></p><?php if(!$valid): ?><div class="notice error"><?=e(t($dateError))?></div><?php endif ?><div class="cards"><?php hotel_cards($hotels); ?></div><?php if(!$hotels&&$valid): ?><div class="empty"><h3><?=e(t('A new route awaits.'))?></h3><p><?=e(t('Try another destination, guest count or dates.'))?></p><a href="<?=e(url('stays'))?>" class="text-link"><?=e(t('See all stays ↗'))?></a></div><?php endif ?></section>

<?php require ROOT.'/includes/page-end.php'; ?>
