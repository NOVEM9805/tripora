<?php // Six native inputs remain usable without JavaScript. ?>
<fieldset class="otp-fieldset" data-otp>
<legend><?=e(t('Verification code'))?></legend>
<div class="otp-boxes">
<?php for($digit=1;$digit<=6;$digit++): ?>
<input class="otp-digit" name="digits[]" type="text" inputmode="numeric" pattern="[0-9]" maxlength="<?=$digit===1?6:1?>" autocomplete="<?=$digit===1?'one-time-code':'off'?>" aria-label="<?=e(t('Digit'))?> <?=$digit?>" required>
<?php endfor ?>
</div><input type="hidden" name="code" value="" data-otp-code>
<p class="muted otp-hint"><?=e(t('Enter the six-digit code. You can paste the full code.'))?></p>
</fieldset>
