<?php
function gallery_ready(): bool {
    static $ready;
    return $ready??=one("SHOW TABLES LIKE 'destination_images'")!==null;
}
function gallery_items(int $destination): array {
    if(!gallery_ready())return [];
    $rows=all('SELECT id,image,position FROM destination_images WHERE destination_id=? ORDER BY position,id',[$destination]);
    foreach($rows as &$row){$row['src']=photo($row['image']);$row['id']=(int)$row['id'];}unset($row);
    return $rows;
}
function public_image_path(string $path): bool {
    return (bool)preg_match('~^public/(images/[a-z0-9_-]+\.(jpg|png|webp)|uploads/[a-f0-9]+\.(jpg|png|webp))$~D',$path)&&is_file(ROOT.'/'.$path);
}
