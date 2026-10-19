<?php $galleryPhotos=destination_photos($item);$galleryName=t($item['name']); ?>
<div class="destination-gallery" data-destination-gallery data-load-error="<?=e(t('Photo could not be loaded. Please try another.'))?>" role="region" aria-label="<?=e(t('Destination photos'))?>">
 <div class="destination-gallery-stage" data-gallery-stage tabindex="0" aria-label="<?=e(t('Use arrow keys to browse photos'))?>">
  <img class="detail-photo" data-gallery-main src="<?=e($galleryPhotos[0])?>" alt="<?=e($galleryName.' · '.t('Photo').' 1')?>" fetchpriority="high" draggable="false">
  <?php if(count($galleryPhotos)>1): ?><button class="gallery-arrow gallery-prev" type="button" data-gallery-prev aria-label="<?=e(t('Previous photo'))?>" hidden>‹</button><button class="gallery-arrow gallery-next" type="button" data-gallery-next aria-label="<?=e(t('Next photo'))?>" hidden>›</button><?php endif ?>
 </div>
 <div class="destination-thumbnails" aria-label="<?=e(t('Choose a photo'))?>">
  <?php foreach($galleryPhotos as $i=>$src): ?><a class="destination-thumbnail <?=$i===0?'active':''?>" href="<?=e($src)?>" data-gallery-thumbnail data-src="<?=e($src)?>" data-alt="<?=e($galleryName.' · '.t('Photo').' '.($i+1))?>" aria-label="<?=e(t('Photo').' '.($i+1))?>" aria-current="<?=$i===0?'true':'false'?>"><img src="<?=e($src)?>" alt="<?=e($galleryName.' · '.t('Photo').' '.($i+1))?>" width="54" height="42" loading="lazy" draggable="false"></a><?php endforeach ?>
 </div>
 <p class="gallery-caption"><span><?=e($galleryName)?></span><span data-gallery-count aria-live="polite">1 / <?=count($galleryPhotos)?></span></p>
 <p class="muted" role="status" data-gallery-feedback></p>
</div>
