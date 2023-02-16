<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Midtrans\Config::$isProduction = false;
Midtrans\Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];

$notif = new Midtrans\Notification();

$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;
$tanggal = $notif->transaction_time;
$matauang = $notif->currency;

$message = 'ok';

if ($transaction == 'capture') {
    // For credit card transaction, we need to check whether transaction is challenge by FDS or not
    if ($type == 'credit_card') {
        if ($fraud == 'challenge') {
            // set payment status in merchant's database to 'Challenge by FDS'
            // merchant should decide whether this transaction is authorized or not in MAP
            $message = "Transaction order_id: " . $order_id . " is challenged by FDS";
        } else {
            // set payment status in merchant's database to 'Success'
            $message = "Transaction order_id: " . $order_id . " successfully captured using " . $type;
        }
    }
} elseif ($transaction == 'settlement') {
    // set payment status in merchant's database to 'Settlement'
    $message = "Transaction order_id: " . $order_id . " successfully transfered using " . $type . " Pada tanggal " . $tanggal . "Dibayar dengan uang ". $matauang;
} elseif ($transaction == 'pending') {
    // set payment status in merchant's database to 'Pending'
    $message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
} elseif ($transaction == 'deny') {
    // set payment status in merchant's database to 'Denied'
    $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
} elseif ($transaction == 'expire') {
    // set payment status in merchant's database to 'expire'
    $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
} elseif ($transaction == 'cancel') {
    // set payment status in merchant's database to 'Denied'
    $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
}

$filename = $order_id . ".txt";
$dirpath = 'log';
is_dir($dirpath) || mkdir($dirpath, 0777, true);


json_decode( file_put_contents($dirpath . "/" . $filename, $message));


