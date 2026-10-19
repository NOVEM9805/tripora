<?php
function catalogue_id(array $input,string $key): int {
    $value=$input[$key]??'';if($value==='')return 0;
    $id=filter_var($value,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);
    if(!$id)throw new DomainException('Choose a valid filter.');return $id;
}
function admin_catalogue(string $entity,array $input): array {
    if(!in_array($entity,['destinations','hotels'],true))throw new DomainException('Unknown record type.');
    $country=catalogue_id($input,'country_id');$destination=$entity==='hotels'?catalogue_id($input,'destination_id'):0;
    $search=$input['q']??'';
    if(!is_string($search)||strlen($search)>400||preg_match_all('/./us',$search)>100)throw new DomainException('Keep the search text under 100 characters.');
    $search=trim($search);$page=max(1,catalogue_id($input,'list_page')?:1);
    if($country&&!one('SELECT id FROM countries WHERE id=?',[$country]))throw new DomainException('Choose a valid country.');
    if($destination&&!one('SELECT id FROM destinations WHERE id=? AND country_id=?',[$destination,$country]))throw new DomainException('Choose a destination in the selected country.');
    $destinations=$country?all('SELECT id,name FROM destinations WHERE country_id=? ORDER BY name,id',[$country]):[];
    $result=['country_id'=>$country,'destination_id'=>$destination,'q'=>$search,'page'=>$page,'per_page'=>20,'total'=>0,'pages'=>1,'rows'=>[],'destinations'=>$destinations];
    if(!$country&&$search==='')return $result;
    $from=$entity==='destinations'?'destinations r JOIN countries c ON c.id=r.country_id':'hotels r JOIN destinations d ON d.id=r.destination_id JOIN countries c ON c.id=d.country_id';
    $where=[];$params=[];
    if($country){$where[]='c.id=?';$params[]=$country;}
    if($destination){$where[]='r.destination_id=?';$params[]=$destination;}
    if($search!==''){
        // Search literally: user % and _ are not wildcard operators.
        $pattern='%'.strtr($search,['!'=>'!!','%'=>'!%','_'=>'!_']).'%';
        $field=$entity==='destinations'?'r.location':'r.address';
        $where[]="(r.name LIKE ? ESCAPE '!' OR $field LIKE ? ESCAPE '!')";$params[]=$pattern;$params[]=$pattern;
    }
    $condition=implode(' AND ',$where);
    $result['total']=(int)one("SELECT COUNT(*) AS total FROM $from WHERE $condition",$params)['total'];
    $result['pages']=max(1,(int)ceil($result['total']/20));$result['page']=min($page,$result['pages']);
    $offset=($result['page']-1)*20;
    $extra=$entity==='destinations'?'c.name AS parent_name':'d.name AS parent_name,c.name AS country_name';
    $result['rows']=all("SELECT r.*,$extra FROM $from WHERE $condition ORDER BY r.id DESC LIMIT 20 OFFSET $offset",$params);
    return $result;
}
function admin_entity_rows(string $section,array $rows,array $filters=[]): string {
    ob_start();
    foreach($rows as $row): ?>
    <tr><td><?=e($row['id'])?></td><td><?=e($row['name']??$row['title'])?><?php if(isset($row['parent_name'])): ?><br><small class="muted"><?=e(t($row['parent_name']))?><?php if(isset($row['country_name'])): ?> · <?=e(t($row['country_name']))?><?php endif ?></small><?php endif ?><?php if($section==='promotions'): ?><br><small><?=e($row['code'])?> · <?=e($row['percent_off'])?>%</small><?php endif ?></td>
    <?php if($section==='rooms'): ?><td><?=money($row['price'])?> · <?=e($row['capacity'])?> <?=e(t('guests ·'))?> <?=e($row['inventory'])?> <?=e(t('rooms'))?></td><?php endif ?>
    <td><span class="badge"><?=e(t($row['active']?'Active':'Inactive'))?></span></td><td><div class="button-row"><a class="text-link" data-record-edit data-record-id="<?=e($row['id'])?>" href="<?=e(url('admin',['section'=>$section,'edit'=>$row['id'],...$filters]))?>"><?=e(t('Edit'))?></a><form method="post" data-confirm="<?=e(t('Delete this record? Deactivate it instead if it has booking history.'))?>"><?=csrf()?><input type="hidden" name="action" value="admin_delete"><input type="hidden" name="entity" value="<?=e($section)?>"><input type="hidden" name="id" value="<?=e($row['id'])?>"><?php foreach($filters as $key=>$value): ?><input type="hidden" name="return_<?=e($key)?>" value="<?=e($value)?>"><?php endforeach ?><button class="plain danger"><?=e(t('Delete'))?></button></form></div></td></tr>
    <?php endforeach;
    return (string)ob_get_clean();
}
