<?php
require_once(__DIR__ . '/vendor/autoload.php');

// inject credentials
$token = "public access key";
$secret = "access secret";
$url = "https://XXXXX";

$xApiVersion = "3.0.0"; // string | api version info

// init
$config = new \Maviance\S3PApiClient\Configuration();
$config->setHost($url);
$client = new \Maviance\S3PApiClient\ApiClient($token, $secret, ['verify' => false]);

// trigger request
$apiInstance = new Maviance\S3PApiClient\Service\AccountApi($client, $config);

try {
    $result = $apiInstance->accountGet($xApiVersion);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AccountApi->accountGet: ', $e->getMessage(), PHP_EOL;
}
?>