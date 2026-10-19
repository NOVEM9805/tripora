<?php
$input=$_GET;
if($record){
    if($section==='destinations')$input['country_id']=$record['country_id'];
    else {$parent=one('SELECT country_id FROM destinations WHERE id=?',[$record['destination_id']]);$input['country_id']=$parent['country_id'];$input['destination_id']=$record['destination_id'];}
}
try{$catalogue=admin_catalogue($section,$input);}catch(DomainException $ex){echo '<p class="notice error">'.e(t($ex->getMessage())).'</p>';$catalogue=admin_catalogue($section,[]);}
$filters=['country_id'=>$catalogue['country_id'],'destination_id'=>$catalogue['destination_id'],'q'=>$catalogue['q'],'list_page'=>$catalogue['page']];
foreach(['country_id','destination_id'] as $key)if(!$filters[$key])unset($filters[$key]);
?>
<div data-admin-catalogue data-entity="<?=e($section)?>" data-endpoint="<?=e(asset('api/admin-catalogue.php'))?>" data-page="<?=e($catalogue['page'])?>">
 <form class="admin-catalogue-filters" method="get" data-catalogue-form>
  <label><?=e(t('Country'))?><select name="country_id" data-catalogue-country><option value=""><?=e(t('All countries'))?></option><?php foreach(all('SELECT id,name FROM countries ORDER BY name') as $country): ?><option value="<?=e($country['id'])?>" <?=((int)$country['id']===$catalogue['country_id'])?'selected':''?>><?=e(t($country['name']))?></option><?php endforeach ?></select></label>
  <?php if($section==='hotels'): ?><label><?=e(t('Destination'))?><select name="destination_id" data-catalogue-destination <?=$catalogue['country_id']?'':'disabled'?>><option value=""><?=e(t('All destinations in this country'))?></option><?php foreach($catalogue['destinations'] as $destination): ?><option value="<?=e($destination['id'])?>" <?=((int)$destination['id']===$catalogue['destination_id'])?'selected':''?>><?=e(t($destination['name']))?></option><?php endforeach ?></select></label><?php endif ?>
  <label class="catalogue-search"><?=e(t('Search'))?><input type="search" name="q" maxlength="100" data-catalogue-search value="<?=e($catalogue['q'])?>" placeholder="<?=e(t($section==='destinations'?'Search destination name or location':'Search hotel name or address'))?>" autocomplete="off"></label>
  <button class="button outline" type="submit"><?=e(t('Search'))?></button>
 </form>
 <p class="muted" role="status" data-catalogue-feedback><?=e(t(!$catalogue['country_id']&&$catalogue['q']===''?'Choose a country or search to view records.':(!$catalogue['total']?'No matching records.':'Results updated.')))?></p>
 <div class="table-wrap" data-catalogue-results <?=$catalogue['total']?'':'hidden'?>><table><thead><tr><th><?=e(t('ID'))?></th><th><?=e(t('Name'))?></th><th><?=e(t('Status'))?></th><th><?=e(t('Manage'))?></th></tr></thead><tbody data-catalogue-rows><?=admin_entity_rows($section,$catalogue['rows'],$filters)?></tbody></table></div>
 <div class="catalogue-pagination" data-catalogue-pager <?=$catalogue['total']?'':'hidden'?>><button class="button outline small" type="button" data-catalogue-prev <?=$catalogue['page']<=1?'disabled':''?>>← <?=e(t('Previous'))?></button><span class="muted" data-catalogue-count><?=e($catalogue['page'].' / '.$catalogue['pages'].' · '.$catalogue['total'])?></span><button class="button outline small" type="button" data-catalogue-next <?=$catalogue['page']>=$catalogue['pages']?'disabled':''?>><?=e(t('Next'))?> →</button></div>
 <noscript><p class="muted"><?=e(t('Choose filters and press Search. Enable JavaScript for live results.'))?></p></noscript>
</div>
