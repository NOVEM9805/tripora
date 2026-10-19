<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='admin';
$section='settings';
require ROOT.'/includes/page-start.php';
 ?>
<div class="panel"><div class="heading-row"><div><h3><?=e(t('Site information'))?></h3><p><?=e(setting('site_tagline'))?></p></div><button class="button outline" data-open="settings-dialog"><?=e(t('Edit settings'))?></button></div><dl class="summary-list"><dt><?=e(t('Email'))?></dt><dd><?=e(setting('contact_email'))?></dd><dt><?=e(t('Phone'))?></dt><dd><?=e(setting('contact_phone'))?></dd><dt><?=e(t('Bank'))?></dt><dd><?=e(setting('bank_account'))?></dd><dt><?=e(t('KPay'))?></dt><dd><?=e(setting('kpay_account'))?></dd><dt><?=e(t('Wave'))?></dt><dd><?=e(setting('wave_account'))?></dd></dl><p class="muted"><?=e(t('SMTP and database credentials are configured in .env, outside these public settings.'))?></p></div>
<dialog id="settings-dialog"><div class="dialog-head"><h2><?=e(t('Edit'))?> <em><?=e(t('settings.'))?></em></h2><button class="close-button" data-close aria-label="<?=e(t('Close'))?>">×</button></div><form class="stack" method="post"><?=csrf()?><input type="hidden" name="action" value="admin_settings"><?php foreach(['site_tagline','contact_email','contact_phone','payment_instructions','bank_account','kpay_account','wave_account'] as $key): ?><label><?=e(t(ucfirst(str_replace('_',' ',$key))))?><?php if($key==='payment_instructions'): ?><textarea name="<?=e($key)?>" maxlength="2000"><?=e(setting($key))?></textarea><?php else: ?><input name="<?=e($key)?>" value="<?=e(setting($key))?>" maxlength="2000"><?php endif ?></label><?php endforeach ?><button class="button"><?=e(t('Save settings'))?></button></form></dialog>

<div class="panel email-diagnostics">
 <p class="eyebrow"><?=e(t('EMAIL DELIVERY'))?></p><h3><?=e(t('Check your email connection'))?></h3>
 <p class="muted"><?=e(t('Check a registered email to see account status and recent OTP delivery attempts.'))?></p>
 <form class="stack" method="post" action="<?=e(asset('api/email-diagnostics.php'))?>" data-email-diagnostics><?=csrf()?>
  <label><?=e(t('Customer email address'))?><input type="email" name="email" maxlength="190" required autocomplete="off"></label>
  <div class="button-row"><button class="button" name="mode" value="check"><?=e(t('Check email'))?></button><button class="button outline" name="mode" value="test" formnovalidate><?=e(t('Send test to my admin email'))?></button></div>
  <small class="muted"><?=e(t('Test emails go only to your signed-in admin email. They do not change any OTP or password.'))?></small>
 </form>
 <p role="status" data-email-feedback></p><div data-email-results hidden><p data-email-account></p><p class="muted" data-email-config></p><div class="table-wrap"><table><thead><tr><th><?=e(t('Time (UTC)'))?></th><th><?=e(t('Purpose'))?></th><th><?=e(t('Status'))?></th><th><?=e(t('Details'))?></th></tr></thead><tbody data-email-history></tbody></table></div></div>
 <p class="muted"><?=e(t('SMTP accepted means the mail server accepted the message; it does not confirm Inbox delivery. Check Spam as well.'))?></p>
</div>
<?php require ROOT.'/includes/page-end.php'; ?>
