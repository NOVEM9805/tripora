<?php
function support_ready(): bool {
    static $ready;
    if($ready===null){try{query('SELECT id FROM support_threads LIMIT 1');$ready=true;}catch(PDOException $ex){$ready=false;}}
    return $ready;
}
function support_thread(int $id,array $u): ?array {
    return one("SELECT t.*,u.name customer_name,u.email FROM support_threads t JOIN users u ON u.id=t.customer_id WHERE t.id=?".($u['role']==='customer'?' AND t.customer_id=?':''),$u['role']==='customer'?[$id,$u['id']]:[$id]);
}
function link_guest_contacts(array $u,int $thread): void {
    if(!$u['email_verified_at'])return;
    query("INSERT INTO support_messages (thread_id,sender_id,sender_role,body,legacy_contact_id,created_at) SELECT ?,?,'customer',c.message,c.id,c.created_at FROM contacts c WHERE c.email=? ON DUPLICATE KEY UPDATE legacy_contact_id=VALUES(legacy_contact_id)",[$thread,$u['id'],$u['email']]);
    query('UPDATE support_threads SET last_message_at=GREATEST(last_message_at,COALESCE((SELECT MAX(created_at) FROM support_messages WHERE thread_id=?),last_message_at)) WHERE id=?',[$thread,$thread]);
}
function customer_thread(array $u): array {
    query('INSERT INTO support_threads (customer_id) VALUES (?) ON DUPLICATE KEY UPDATE customer_id=VALUES(customer_id)',[$u['id']]);
    $thread=one('SELECT * FROM support_threads WHERE customer_id=?',[$u['id']]);link_guest_contacts($u,(int)$thread['id']);return $thread;
}
function support_send(array $u,int $thread,string $body,string $nonce): void {
    if(!in_array($u['role'],['customer','admin'],true)||!support_thread($thread,$u))throw new DomainException('Conversation not found.');
    $body=trim($body);
    if($body===''||strlen($body)>12000||preg_match_all('/./us',$body)>3000)throw new DomainException('Enter a message up to 3000 characters.');
    if(!preg_match('/^[a-zA-Z0-9_-]{16,64}$/D',$nonce))throw new DomainException('Invalid message request.');
    $db=$GLOBALS['db'];$db->beginTransaction();
    try{
        query('SELECT id FROM support_threads WHERE id=? FOR UPDATE',[$thread]);
        query('INSERT INTO support_messages (thread_id,sender_id,sender_role,body,client_nonce) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE client_nonce=VALUES(client_nonce)',[$thread,$u['id'],$u['role'],$body,$nonce]);
        query("UPDATE support_threads SET status='open',last_message_at=UTC_TIMESTAMP() WHERE id=?",[$thread]);$db->commit();
    }catch(Throwable $ex){if($db->inTransaction())$db->rollBack();throw $ex;}
}
function support_threads(): array {
    return all("SELECT t.*,u.name customer_name,u.email,(SELECT COUNT(*) FROM support_messages m WHERE m.thread_id=t.id AND m.sender_role='customer' AND m.id>t.admin_last_read) unread FROM support_threads t JOIN users u ON u.id=t.customer_id ORDER BY t.last_message_at DESC,t.id DESC LIMIT 200");
}
function chat_shell(array $thread): void {
    $u=$GLOBALS['user'];
    $messages=all('SELECT m.*,u.name sender_name FROM support_messages m JOIN users u ON u.id=m.sender_id WHERE m.thread_id=? ORDER BY m.id LIMIT 100',[$thread['id']]);
    $last=$messages?max(array_column($messages,'id')):0;
    $read=$u['role']==='admin'?'admin_last_read':'customer_last_read';query("UPDATE support_threads SET $read=GREATEST($read,?) WHERE id=?",[$last,$thread['id']]);
    ?>
    <section class="chat-panel panel" data-chat="<?=e($thread['id'])?>" data-endpoint="<?=e(asset('api/chat.php'))?>" data-last="<?=e($last)?>">
    <div class="heading-row"><div><p class="eyebrow"><?=e(t('TRIPORA SUPPORT'))?></p><h3><?=e($u['role']==='admin'?$thread['customer_name']:t('Chat with our team'))?></h3><p class="muted"><?=e($u['role']==='admin'?$thread['email']:t('Your conversation is private.'))?></p></div><span class="badge" data-chat-status><?=e(t($thread['status']))?></span></div>
    <div class="chat-history" aria-label="<?=e(t('Conversation messages'))?>" aria-live="polite" aria-relevant="additions text">
    <?php foreach($messages as $m): ?><article class="chat-bubble <?=$m['sender_role']===$u['role']?'mine':''?>" data-message="<?=e($m['id'])?>"><strong><?=e($m['sender_role']==='admin'?t('Tripora team'):$m['sender_name'])?></strong><p><?=nl2br(e($m['body']))?></p><time><?=e($m['created_at'])?> <?=e(t('UTC'))?></time></article><?php endforeach ?>
    <?php if(!$messages): ?><p class="chat-empty muted"><?=e(t('Send a message to start your conversation.'))?></p><?php endif ?></div>
    <p class="chat-feedback muted" role="status"></p><form class="stack chat-form" method="post"><?=csrf()?><input type="hidden" name="action" value="chat_send"><input type="hidden" name="thread_id" value="<?=e($thread['id'])?>"><input type="hidden" name="client_nonce" value="<?=e(bin2hex(random_bytes(16)))?>"><label><?=e(t('Your message'))?><textarea name="message" rows="3" maxlength="3000" required placeholder="<?=e(t('Ask about your stay or booking...'))?>"></textarea></label><button class="button"><?=e(t('Send message ↗'))?></button></form></section>
    <?php
}
