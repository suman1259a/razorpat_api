<?php
header('Content-Type: application/json');
require "vendor/autoload.php";
use Razorpay\Api\Api;

$keyID = "rzp_test_wAAyaW18l57Y4t";
$keySecret = "WNjgtr3FrUEUnc1VDR9aBQci";

$api = new Api($keyID, $keySecret);

if (isset($_GET["price"]) && isset($_GET["customer_id"])) {
    $price = (int)$_GET['price'];
    $customer_id = $_GET["customer_id"];
    $receipt = "order_receipt_" . rand(1, 10000) . "_" . time();
    $currency = "INR";

    $order = $api->order->create([
        'receipt' => $receipt,
        'amount' => $price * 100,
        'currency' => $currency,
    ]);

    $order_details['order_id'] = $order['id'];
    $order_details['customer_id'] = $customer_id;;
    $order_details['receipt'] = $order['receipt'];
    $order_details['amount'] = $order['amount'];
    $order_details['currency'] = $order['currency'];
    $order_details['keyID'] = $keyID;

    echo json_encode($order_details, JSON_PRETTY_PRINT);
} else {
    // Handle the case when customer_id or price is not provided
    echo json_encode(['error' => 'customer_id and price are required'], JSON_PRETTY_PRINT);
}
?>