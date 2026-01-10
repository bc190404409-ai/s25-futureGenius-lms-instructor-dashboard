<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Boot the application kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
// Bootstrap the application so configs/providers are loaded
$kernel->bootstrap();

// Get URL generator
$url = $app->make('url');
$loginUrl = $url->route('login.form', ['redirect' => $url->route('dashboard')]);
echo $loginUrl . PHP_EOL;