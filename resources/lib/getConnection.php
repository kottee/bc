<?php

use Wish\WishClient;
use Wish\Model\WishTracker;
use Wish\Exception\OrderAlreadyFulfilledException;
use Wish\Model\WishReason;

$token = 'b7a3bc5b0a0148208f2e80387f292366';
$client = new WishClient($token,'sandbox');

$changed_orders = $client->getAllChangedOrdersSince();
return $changed_orders;

//$paymentResult = [];

//$paymentResult['version'] = SdkRestApi::getParam('pluginVersion', 'unknown');
//$paymentResult['url'] = SdkRestApi::getParam('urls');
//$paymentResult['id'] = SdkRestApi::getParam('id');
//$paymentResult['transactionId'] = '1234567890';
//$paymentResult['paymentUrl'] = 'TTTSSSS';

//return $paymentResult;

