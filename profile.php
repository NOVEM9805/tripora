<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='profile';require ROOT.'/includes/page-start.php';
$hasPhoto=!empty($user['profile_image']);$change=change_password_state($user);
?>
<section class="wrap section narrow">
<p class="eyebrow"><?=e(t('YOUR OWN LITTLE CORNER'))?></p><h1><?=e(t('Hello,'))?> <em><?=e($user['name'])?>.</em></h1>
<div class="panel"><div class="profile-heading"><div class="profile-avatar" aria-label="<?=e(t('Profile photo'))?>"><?php if($hasPhoto): ?><img src="<?=e(avatar_url($user))?>" alt="<?=e(t('Your profile photo'))?>"><?php else: ?><span><?=e(profile_initial($user))?></span><?php endif ?></div><div><h3><?=e(t('Your profile'))?></h3><p class="muted"><?=e(t('Make this space your own.'))?></p></div><button class="button outline small" data-open="edit-profile"><?=e(t('Edit profile'))?></button></div>
<dl class="summary-list"><dt><?=e(t('Name'))?></dt><dd><?=e($user['name'])?></dd><dt><?=e(t('Email'))?></dt><dd><?=e($user['email'])?></dd><dt><?=e(t('Phone'))?></dt><dd><?=e($user['phone']?:t('Not added yet'))?></dd><dt><?=e(t('Account'))?></dt><dd><?=e(t(ucfirst($user['role'])))?></dd></dl>
<div class="button-row"><?php if(is_customer()): ?><a class="button" href="<?=e(url('trips'))?>"><?=e(t('My trips ↗'))?></a><?php else: ?><a class="button" href="<?=e(url('admin'))?>"><?=e(t('Dashboard'))?></a><?php endif ?>
<button class="button outline" data-open="edit-password"><?=e(t('Change password'))?></button><?php if($change): ?><a class="text-link" href="<?=e(url('change'))?>"><?=e(t('Continue password change'))?></a><?php endif ?><form method="post"><?=csrf()?><input type="hidden" name="action" value="logout"><button class="button outline"><?=e(t('Sign out'))?></button></form></div></div>
</section>
<dialog id="edit-profile"><div class="dialog-head"><h2><?=e(t('Edit'))?> <em><?=e(t('profile.'))?></em></h2><button class="close-button" data-close aria-label="<?=e(t('Close'))?>">×</button></div>
<form class="stack" method="post" enctype="multipart/form-data" data-profile-form><?=csrf()?><input type="hidden" name="action" value="profile">
<div class="profile-photo-editor"><div class="profile-avatar"><img data-profile-preview <?php if($hasPhoto): ?>src="<?=e(avatar_url($user))?>"<?php else: ?>hidden<?php endif ?> alt="<?=e(t('Profile photo preview'))?>"><span data-profile-placeholder <?=$hasPhoto?'hidden':''?>><?=e(profile_initial($user))?></span></div><div><label><?=e(t('Profile photo'))?><input type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp" data-profile-photo></label><small class="muted"><?=e(t('JPG, PNG or WebP, up to 5 MB.'))?></small><?php if($hasPhoto): ?><label class="check-inline"><input type="checkbox" name="remove_photo" value="1" data-remove-photo><?=e(t('Remove current photo'))?></label><?php endif ?></div></div>
<p class="muted" role="status" data-photo-feedback></p>
<label><?=e(t('Name'))?><input name="name" value="<?=e($user['name'])?>" maxlength="120" autocomplete="name" required></label><label><?=e(t('Phone'))?><input name="phone" value="<?=e($user['phone'])?>" maxlength="40" autocomplete="tel"></label><button class="button"><?=e(t('Save profile'))?></button></form></dialog>
<dialog id="edit-password"><div class="dialog-head"><h2><?=e(t('Change'))?> <em><?=e(t('password.'))?></em></h2><button class="close-button" data-close aria-label="<?=e(t('Close'))?>">×</button></div>
<p class="muted"><?=e(t('Confirm your current password. We will email you a code before you can choose a new password.'))?></p>
<form class="stack" method="post"><?=csrf()?><input type="hidden" name="action" value="password_start"><label><?=e(t('Current password'))?><input type="password" name="current_password" autocomplete="current-password" required></label><button class="button"><?=e(t('Send verification code'))?> ↗</button></form></dialog>
<?php require ROOT.'/includes/page-end.php'; ?>
