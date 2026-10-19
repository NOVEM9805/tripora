<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='setup';
require ROOT.'/includes/page-start.php';
 ?>
<section class="wrap section narrow"><p class="eyebrow"><?=e(t('FIRST RUN ONLY'))?></p><h1><?=e(t('Make Tripora'))?> <em><?=e(t('yours.'))?></em></h1><?php if(one("SELECT id FROM users WHERE role='admin'")): ?><p><?=e(t('Administrator setup is already complete.'))?></p><a class="button" href="<?=e(url('admin_login'))?>"><?=e(t('Sign in ↗'))?></a><?php else: ?><p><?=e(t('Create your first administrator. No default admin password is included.'))?></p><form class="panel stack" method="post"><?=csrf()?><input type="hidden" name="action" value="setup"><label><?=e(t('Name'))?><input name="name" maxlength="120" required></label><label><?=e(t('Email'))?><input type="email" name="email" maxlength="190" required></label><label><?=e(t('Password'))?><input type="password" name="password" minlength="8" maxlength="72" required></label><label><?=e(t('Setup token'))?> <span class="muted"><?=e(t('(required remotely, or when configured in .env)'))?></span><input type="password" name="setup_token"></label><button class="button"><?=e(t('Create administrator'))?></button></form><?php endif ?></section>

<?php require ROOT.'/includes/page-end.php'; ?>
