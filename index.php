<?php

require 'functions.php';

spl_autoload_register(function($classname) {
    $filepath = strtr($classname, '\\', '/') . '.php';
    if (file_exists($filepath)) {
        require $filepath;
    }
});

// CORS headers.
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');

$path = \explode('/', $_GET['q'], 2);
$method = $_SERVER['REQUEST_METHOD'];

switch($path[0]) {
    case 'generate':
        if ($method === 'POST') {
            ['boundStart' => $boundStart, 'boundEnd' => $boundEnd] = $_POST;
            generateNumber($boundStart, $boundEnd);
            break;
        }
    case 'get':
        if ($method === 'GET') {
            getNumber($path[1] ?? null);
            break;
        }
    default:
        notFound();
        break;
}

?>