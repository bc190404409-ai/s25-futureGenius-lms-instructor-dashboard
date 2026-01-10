<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Build the login URL using the router so it reflects APP_URL
$url = $app->make('url');
$target = $url->route('login.form');

$ch = curl_init($target);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
print_r($info);
