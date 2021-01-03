<?php

use Stripe\Price;

require 'vendor/autoload.php';
// This is your real test secret API key.
\Stripe\Stripe::setApiKey('sk_test_51I3nIsH16SJVNtXAMXERA1S3DQNhbirM7AifeCecl1mysFBvyH5eoXgfoe1sxnMSqSAgru8csvIfPioLgJNNJYCb00h6T3L2ST');
function calculateOrderAmount(array $items): int
{
    // Replace this constant with a calculation of the order's amount
    // Calculate the order total on the server to prevent
    // customers from directly manipulating the amount on the client


    // this below works
    $price = $items;

    if ($price == 5) {
        return 5000;
    } else {
        return 2000;
    }
    // wont work with variable
    // return $price;

    //foreach($items as $item) {
    // Do something with $item->id
    // }

    // foreach ($items as $item) {
    //     return $item[0];
    // }
}
header('Content-Type: application/json');
try {
    // retrieve JSON from POST body
    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str);
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => calculateOrderAmount($json_obj->items),
        'currency' => 'usd',
    ]);
    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];
    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
