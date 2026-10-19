<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='admin';
$section='reviews';
require ROOT.'/includes/page-start.php';
 ?>
<div class="table-wrap"><table><thead><tr><th><?=e(t('Customer / hotel'))?></th><th><?=e(t('Review'))?></th><th><?=e(t('Visibility'))?></th></tr></thead><tbody><?php foreach(all('SELECT rv.*,u.name,h.name hotel_name FROM reviews rv JOIN users u ON u.id=rv.user_id JOIN hotels h ON h.id=rv.hotel_id ORDER BY rv.id DESC LIMIT 200') as $r): ?><tr><td><?=e($r['name'])?><br><small><?=e($r['hotel_name'])?></small></td><td><strong><?=e($r['rating'])?> / 5</strong><p><?=e($r['body'])?></p></td><td><form method="post"><?=csrf()?><input type="hidden" name="action" value="admin_review"><input type="hidden" name="id" value="<?=e($r['id'])?>"><button class="button small outline"><?=e(t($r['visible']?'Hide':'Publish'))?></button></form></td></tr><?php endforeach ?></tbody></table></div>

<?php require ROOT.'/includes/page-end.php'; ?>
