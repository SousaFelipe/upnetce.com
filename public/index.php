<?php
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;



define('LARAVEL_START', microtime(true));
define('LOCAL', true);


$appdir = LOCAL ? '/..' : '/../application';


$maintenance = $appdir . '/storage/framework/maintenance.php';
$bootatrap = $appdir . '/bootstrap/app.php';


if (file_exists(__DIR__ . $maintenance)) {
    require __DIR__ . $maintenance;
}


require __DIR__ . $appdir . '/vendor/autoload.php';


$app = require_once __DIR__ . $bootatrap;
$kernel = $app->make(Kernel::class);


$response = tap($kernel->handle(
    $request = Request::capture()
))->send();


$kernel->terminate($request, $response);
