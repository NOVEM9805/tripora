<?php
if($page==='admin')echo '</section></div>';
else echo '</main>';
require ROOT.'/includes/footer.php';
ob_end_flush();
