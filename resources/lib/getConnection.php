<?php

$client = new \GuzzleHttp\Client();
$res = $client->request(
    'GET',
    'https://packagist.org/search.json',
    [
        'query' => ['q' => SdkRestApi::getParam('packagist_query')]
    ]
);
 
/** @return array */
return json_decode($res->getBody(), true);

//$paymentResult = [];

//$paymentResult['version'] = SdkRestApi::getParam('pluginVersion', 'unknown');
//$paymentResult['url'] = SdkRestApi::getParam('urls');
//$paymentResult['id'] = SdkRestApi::getParam('id');
//$paymentResult['transactionId'] = '1234567890';
//$paymentResult['paymentUrl'] = 'TTTSSSS';

//return $paymentResult;

