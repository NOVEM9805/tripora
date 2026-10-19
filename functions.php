<?php
declare(strict_types=1);
function e(mixed $value): string { return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8'); }
function query(string $sql, array $params = []): PDOStatement {
    global $db;
    $st = $db->prepare($sql); $st->execute($params); return $st;
}
function all(string $sql, array $params = []): array { return query($sql, $params)->fetchAll(); }
function one(string $sql, array $params = []): ?array { return query($sql, $params)->fetch() ?: null; }
function asset(string $path): string { return BASE_PATH.'/'.ltrim($path,'/'); }
function url(string $page='home',array $args=[]): string {
    $routes=['home'=>'customer/home.php','explore'=>'customer/explore.php','country'=>'customer/country.php','destination'=>'customer/destination.php','stays'=>'customer/stays.php','hotel'=>'customer/hotel.php','saved'=>'customer/saved.php','trips'=>'customer/trips.php','booking'=>'customer/booking.php','profile'=>'customer/profile.php','contact'=>'customer/contact.php','proof'=>'customer/receipt.php','login'=>'auth/login.php','register'=>'auth/register.php','verify'=>'auth/verify-otp.php','forgot'=>'auth/forgot-password.php','reset'=>'auth/new-password.php','change'=>'auth/change-password.php','logout'=>'auth/logout.php','admin_login'=>'admin/login.php','admin_logout'=>'admin/logout.php','setup'=>'admin/setup-admin.php','wishlist'=>'api/wishlist.php'];
    if($page==='admin'){
        $section=(string)($args['section']??'dashboard');unset($args['section']);
        if(!in_array($section,['dashboard','countries','destinations','hotels','rooms','bookings','payments','customers','reviews','promotions','messages','settings'],true))throw new DomainException('Unknown admin page.');
        $path='admin/'.$section.'.php';
    }else{$path=$routes[$page]??null;if(!$path)throw new DomainException('Unknown page.');}
    return asset($path).($args?'?'.http_build_query($args):'');
}
function redirect(string $page, array $args = []): never { header('Location: ' . url($page, $args)); exit; }
function money(mixed $amount): string { return '$' . number_format((float)$amount, 2); }
function setting(string $key, string $default = ''): string {
    static $settings;
    if ($settings === null) $settings = array_column(all('SELECT setting_key,setting_value FROM settings'), 'setting_value', 'setting_key');
    return $settings[$key] ?? $default;
}
function flash(string $message, string $type = 'success'): void { $_SESSION['flash'][] = ['message' => $message, 'type' => $type]; }
function csrf(): string {
    $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
    return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">';
}
function check_csrf(): void {
    if (!isset($_POST['csrf'], $_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], (string)$_POST['csrf'])) {
        http_response_code(419); exit(e(t('Your session has expired. Reload the page and try again.')));
    }
}
function require_user(): array {
    global $user;
    if (!$user) { flash('Please sign in to continue.', 'info'); redirect('login'); }
    return $user;
}
function is_customer(): bool {global $user;return $user && $user['role']==='customer';}
function require_customer(): array {
    $u=require_user();
    if($u['role']!=='customer'){http_response_code(403);exit(e(t('This action is available to customer accounts only. Use the administrator dashboard to manage the website.')));}
    return $u;
}
function require_admin(): array {
    global $user;
    if(!$user){flash('Sign in with your administrator account.','info');redirect('admin_login');}
    $u=$user;
    if ($u['role'] !== 'admin') { http_response_code(403); exit(e(t('Admin access required.'))); }
    return $u;
}
function text_input(string $key, int $max = 5000, bool $required = true): string {
    $v = trim((string)($_POST[$key] ?? ''));
    if (($required && $v === '') || strlen($v) > $max) throw new DomainException('Please enter a valid ' . str_replace('_', ' ', $key) . '.');
    return $v;
}
function valid_email(string $value): string {
    $v = strtolower(trim($value));
    if (strlen($v)>190 || !filter_var($v, FILTER_VALIDATE_EMAIL)) throw new DomainException('Please enter a valid email address.');
    return $v;
}
function password_input(): string {
    $p = (string)($_POST['password'] ?? '');
    if (strlen($p) < 8 || strlen($p)>72) throw new DomainException('Use a password of 8–72 characters.');
    return $p;
}
function audit(string $action, string $detail): void {
    global $user;
    query('INSERT INTO audit_logs (user_id,action,detail) VALUES (?,?,?)', [$user['id'] ?? null, $action, substr($detail,0,500)]);
}
function throttle(string $scope, string $identity, int $limit = 8, int $seconds = 900): void {
    $key = hash('sha256', $scope . '|' . $identity);
    $now = time();
    query('INSERT INTO login_attempts (attempt_key,attempts,window_start) VALUES (?,1,?) ON DUPLICATE KEY UPDATE attempts=IF(window_start < ?,1,attempts+1), window_start=IF(window_start < ?,VALUES(window_start),window_start)', [$key,$now,$now-$seconds,$now-$seconds]);
    $r = one('SELECT attempts FROM login_attempts WHERE attempt_key=?',[$key]);
    if ((int)$r['attempts'] > $limit) throw new DomainException('Too many attempts. Please try again in a few minutes.');
}
function photo(string $path): string {
    return preg_match('~^public/(images/[a-z0-9_-]+\.(jpg|png|webp)|uploads/[a-f0-9]+\.(jpg|png|webp))$~D', $path) ? asset($path) : asset('public/images/hotel.jpg');
}
function destination_photos(array $destination): array {
    $photos=[];$paths=[(string)($destination['image']??'')];
    if(gallery_ready())foreach(gallery_items((int)$destination['id']) as $row)$paths[]=$row['image'];
    else foreach(['image_2','image_3'] as $key)$paths[]=(string)($destination[$key]??'');
    foreach($paths as $path)if(public_image_path($path))$photos[$path]=photo($path);
    return $photos?array_values($photos):[photo('public/images/hotel.jpg')];
}
function save_upload(string $field, bool $private = false): string {
    $f = $_FILES[$field] ?? null;
    if (!$f || $f['error'] !== UPLOAD_ERR_OK || $f['size'] > 5 * 1024 * 1024) throw new DomainException('Upload a JPG, PNG or WebP image up to 5 MB.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $extensions = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
    if (!isset($extensions[$mime]) || !getimagesize($f['tmp_name'])) throw new DomainException('The uploaded file must be an image.');
    $folder = $private ? ROOT . '/storage/private' : ROOT . '/public/uploads';
    if (!is_dir($folder)) mkdir($folder, 0750, true);
    $name = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
    if (!move_uploaded_file($f['tmp_name'], $folder . '/' . $name)) throw new DomainException('Could not save the image.');
    return $private ? $name : 'public/uploads/' . $name;
}
function send_code(string $email,string $name,string $kind): void {
    if($kind==='change'){
        $column=one("SHOW COLUMNS FROM auth_tokens LIKE 'kind'");
        if(!$column||!str_contains($column['Type'],"'change'"))throw new DomainException('Run database/upgrade_v3.sql before changing your password.');
    }
    $old=one('SELECT created_at FROM auth_tokens WHERE email=? AND kind=?',[$email,$kind]);
    if($old&&strtotime($old['created_at'])>time()-60)throw new DomainException('Wait one minute before requesting another code.');
    $code=(string)random_int(100000,999999);$hash=password_hash($code,PASSWORD_DEFAULT);
    query('INSERT INTO auth_tokens (email,kind,code_hash,expires_at,attempts) VALUES (?,?,?,DATE_ADD(UTC_TIMESTAMP(),INTERVAL 10 MINUTE),0) ON DUPLICATE KEY UPDATE code_hash=VALUES(code_hash),expires_at=VALUES(expires_at),attempts=0,created_at=UTC_TIMESTAMP()',[$email,$kind,$hash]);
    try{deliver_otp($email,$name,$kind,$code);}catch(Throwable $ex){
        query('DELETE FROM auth_tokens WHERE email=? AND kind=? AND code_hash=?',[$email,$kind,$hash]);
        throw $ex;
    }
    $_SESSION['otp_cooldowns'][$kind]=['email'=>$email,'until'=>time()+60];
}
function saved_hotel_ids(): array {
    global $user;static $ids;
    if($ids===null)$ids=$user?array_fill_keys(array_column(all('SELECT hotel_id FROM wishlists WHERE user_id=?',[$user['id']]),'hotel_id'),true):[];
    return $ids;
}
function save_control(int $hotel,bool $detail=false): void {
    global $user;if(!is_customer())return;
    $saved=isset(saved_hotel_ids()[$hotel]);$pressed=$saved?'true':'false';$label=t($saved?'Unsave stay':'Save stay');
    $class=$detail?'button outline save-detail':'heart';
    ?><form class="<?= $detail?'detail-save-form':'save-form' ?>" method="post" data-wishlist="<?=e($hotel)?>" data-endpoint="<?=e(url('wishlist'))?>"><?=csrf()?><input type="hidden" name="action" value="wishlist"><input type="hidden" name="hotel_id" value="<?=e($hotel)?>"><input type="hidden" name="saved" value="<?=$saved?'0':'1'?>"><button type="submit" class="<?=e($class)?><?=$saved?' is-saved':''?>" aria-pressed="<?=$pressed?>" aria-label="<?=e(t($label))?>"><svg class="heart-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8Z"/></svg><?php if($detail): ?><span data-save-label><?=t($saved?'Saved':'Save stay')?></span><?php endif ?></button></form><?php
}
function verify_code(string $email, string $kind, string $code): void {
    global $db;
    $db->beginTransaction();
    try {
        $r=one('SELECT * FROM auth_tokens WHERE email=? AND kind=? FOR UPDATE',[$email,$kind]);
        if (!$r || strtotime($r['expires_at'])<time() || (int)$r['attempts']>=5) throw new DomainException('The code expired. Please request a new code.');
        if (!password_verify($code,$r['code_hash'])) {
            query('UPDATE auth_tokens SET attempts=attempts+1 WHERE id=?',[$r['id']]);
            $db->commit(); throw new DomainException('That code is incorrect.');
        }
        query('DELETE FROM auth_tokens WHERE id=?',[$r['id']]);
        $db->commit();
    } catch(Throwable $ex) { if($db->inTransaction()) $db->rollBack(); throw $ex; }
}
function hotel_cards(array $hotels): void {
    global $user;
    foreach($hotels as $h): ?>
    <article class="stay-card">
      <a class="card-photo" href="<?=e(url('hotel',['id'=>$h['id']]))?>"><img loading="lazy" src="<?=e(photo($h['image']))?>" alt="<?=e($h['name'])?>"></a>
      <?php save_control((int)$h['id']); ?>
      <div class="card-body"><span class="eyebrow"><?=e($h['destination_name']??'')?> · <?=e($h['country_name']??'')?></span><h3><a href="<?=e(url('hotel',['id'=>$h['id']]))?>"><?=e($h['name'])?></a></h3>
      <p class="muted"><?=e($h['stars'])?><?=e(t('-star hotel ·'))?> <?=e(t($h['facilities']))?></p>
      <div class="card-foot"><span><?=e(t('From'))?> <strong><?=money($h['price']??0)?></strong> <small><?=e(t('/ night'))?></small></span><a class="text-link" href="<?=e(url('hotel',['id'=>$h['id']]))?>"><?=e(t('View stay ↗'))?></a></div></div>
    </article>
    <?php endforeach;
}
function hotel_list(string $condition='1', array $params=[], int $limit=24): array {
    return all("SELECT h.*,d.name destination_name,c.name country_name,MIN(r.price) price FROM hotels h JOIN destinations d ON d.id=h.destination_id JOIN countries c ON c.id=d.country_id JOIN rooms r ON r.hotel_id=h.id AND r.active=1 WHERE h.active=1 AND d.active=1 AND c.active=1 AND $condition GROUP BY h.id,d.name,c.name ORDER BY h.featured DESC,h.id LIMIT ".(int)$limit,$params);
}
