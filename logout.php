<?php
require dirname(__DIR__).'/includes/bootstrap.php';
$page='logout';
require ROOT.'/includes/page-start.php'; ?>
<section class="wrap section narrow"><h1>Until <em>next time.</em></h1><form method="post"><?=csrf()?><input type="hidden" name="action" value="logout"><button class="button">Sign out</button></form></section>
<?php require ROOT.'/includes/page-end.php'; ?>