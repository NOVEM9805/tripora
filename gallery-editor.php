<?php $initialGallery=$record&&gallery_ready()?gallery_items((int)$record['id']):[]; ?>
<section class="admin-gallery-editor" data-admin-gallery data-endpoint="<?=e(asset('api/destination-images.php'))?>" data-images="<?=e(json_encode($initialGallery,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE))?>">
 <h3><?=e(t('Gallery photos'))?></h3><p class="muted"><?=e(t('Add as many photos as you need. The primary image above appears first.'))?></p>
 <p class="muted" data-gallery-save-first <?=$record?'hidden':''?>><?=e(t('Save the destination first, then open Edit to add gallery photos.'))?></p>
 <div data-gallery-controls <?=$record?'':'hidden'?>>
  <label class="gallery-upload-label"><?=e(t('Add photos'))?><input type="file" data-gallery-add multiple accept="image/jpeg,image/png,image/webp"><small class="muted"><?=e(t('Choose one or more photos. Each JPG, PNG or WebP may be up to 5 MB.'))?></small></label>
  <div class="admin-gallery-list" data-admin-gallery-list></div>
 </div>
 <p class="muted" role="status" data-admin-gallery-feedback></p>
 <?php if(!gallery_ready()): ?><p class="notice error"><?=e(t('Run database/upgrade_v5.sql to enable unlimited gallery photos.'))?></p><?php endif ?>
 <noscript><p><?=e(t('Enable JavaScript to add, replace or remove gallery photos.'))?></p></noscript>
</section>
