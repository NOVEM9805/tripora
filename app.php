<?php
declare(strict_types=1);
$env = [];
if (is_file(ROOT . '/.env')) {
    foreach (file(ROOT . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim(trim($value), "\"'");
    }
}
function env(string $key, string $default = ''): string {
    global $env;
    return $env[$key] ?? $default;
}

$script=str_replace('\\','/',$_SERVER['SCRIPT_NAME']??'/index.php');
$base=preg_replace('~/(customer|auth|admin|api)/[^/]+\.php$~','',$script);
if($base===$script)$base=dirname($script);
define('BASE_PATH',rtrim($base==='.'?'':$base,'/'));
