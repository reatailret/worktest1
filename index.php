<?php

use Worktest\Ipfinder;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
    require_once "vendor/autoload.php";
    $response = [];
    $status = 200;
    $fip = $_GET['ip'] ?? null;
    if ($fip) {
        $ctl = new Ipfinder();
        $response['data'] =  $ctl->findCountry($fip);
    } else {
        
        throw new Exception("Ip not specified", 1);

    }
} catch (\Throwable $th) {
    
    $status = 500;
    $response['errors'] = [$th->getMessage()];
}

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
http_response_code($status);
echo json_encode($response);
