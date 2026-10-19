<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='admin';
$section='customers';
require ROOT.'/includes/page-start.php';
 ?>
<div class="table-wrap"><table><thead><tr><th><?=e(t('Name / email'))?></th><th><?=e(t('Phone'))?></th><th><?=e(t('Verified / status'))?></th><th><?=e(t('Access'))?></th></tr></thead><tbody><?php foreach(all("SELECT * FROM users WHERE role='customer' ORDER BY id DESC LIMIT 200") as $u): ?><tr><td><?=e($u['name'])?><br><small><?=e($u['email'])?></small></td><td><?=e($u['phone'])?></td><td><?=e(t($u['email_verified_at']?'Verified':'Unverified'))?> · <?=e(t($u['active']?'Active':'Disabled'))?></td><td><form method="post"><?=csrf()?><input type="hidden" name="action" value="admin_user"><input type="hidden" name="id" value="<?=e($u['id'])?>"><button class="button small outline"><?=e(t($u['active']?'Disable':'Enable'))?></button></form></td></tr><?php endforeach ?></tbody></table></div>

<?php require ROOT.'/includes/page-end.php'; ?>
