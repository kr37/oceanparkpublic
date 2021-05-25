<?php
echo 'hi';
die;
include_once("../../nonpublic/oceanpark/opBase.php");
include_once(NONPUBLIC_OP . 'Paypal.php');
include_once(NONPUBLIC_OP . "opDatabase.php");

// Verify with PayPal that this is a legitimate transaction
$paypal = New Paypal;
$ppSuccess = $paypal->verifyIPN($_POST);
if (!$ppSuccess) {
    error_log("Transaction not verified. ".date('r')."\nQuitting.\n", 3, ERRORLOG);
    echo 'Must be a test.';
    $_POST = [ 'mc_gross'=>'1.00', 'protection_eligibility'=>'Eligible', 'address_status'=>'confirmed', 'payer_id'=>'BLQC5USM2WX2N', 'address_street'=>'6556 24th Ave NW', 'payment_date'=>'21:53:15 May 24, 2021 PDT', 'payment_status'=>'Completed', 'charset'=>'windows-1252', 'address_zip'=>'98117', 'first_name'=>'Michael', 'mc_fee'=>'0.32', 'address_country_code'=>'US', 'address_name'=>'Michael Defever¬ify_version'=>'3.9', 'custom'=>'Cart Code: 8', 'payer_status'=>'verified', 'business'=>'admin@meditateinolympia.org', 'address_country'=>'United States', 'address_city'=>'Seattle', 'quantity'=>'1', 'verify_sign'=>'AXe-6yOdWRbXfWkuq-z3d9ftf5ZGA6LWjZMdfh-pUKBqEI2W-hwAimvR', 'payer_email'=>'kelsangrinzin@gmail.com', 'txn_id'=>'4GF183167C352401V', 'payment_type'=>'instant', 'last_name'=>'Defever', 'address_state'=>'WA', 'receiver_email'=>'admin@meditateinolympia.org', 'payment_fee'=>'0.32', 'shipping_discount'=>'0.00', 'insurance_amount'=>'0.00', 'receiver_id'=>'GQPCQWGBS2GVY', 'txn_type'=>'web_accept', 'item_name'=>'Pathway to Bliss Weekend Retreat at Ocean Park', 'discount'=>'0.00', 'mc_currency'=>'USD', 'item_number'=>'', 'residence_country'=>'US', 'shipping_method'=>'Default', 'transaction_subject'=>'', 'payment_gross'=>'1.00', 'ipn_track_id'=>'5248846c6f188' ];
    error_log("\n\nBEGINNING FAKE DATA\n\n".print_r($_POST,true)."\n", 3, ERRORLOG);
    die;
}

if (substr($_POST['custom'], 0, 10) != 'Cart Code:') {
    error_log("No cart code in PayPal custom($_POST[custom]). Must be a non-Ocean Park transaction. Exiting.\n\n", 3, ERRORLOG);
    die;
}

// Store the raw transaction
error_log("Storing Paypal transaction in DB\n", 3, ERRORLOG);
$transactionId = storePaypalTransaction($_POST);

// Log and notify
error_log("Starting processSuccessfulPayment.\n", 3, ERRORLOG);
$paypal->processSuccessfulPayment($_POST);

// Find the stored cart
$cartId = $_POST['custom'];
error_log("Looking for cartId: $cartId... ", 3, ERRORLOG);
$carts = file(NONPUBLIC_OP . 'logs/carts.txt', FILE_IGNORE_NEW_LINES);
$cartFound = false;
foreach ($carts as $cart) {
    $cartArray = json_decode($cart, true);
    $cid = $cartArray['cartId'];
    if ($cartId == $cid) {
        $cartFound = true;
        error_log("Found it.\n", 3, ERRORLOG);
        break;
    }
}
if (!$cartFound) {
    error_log("Cart not found!!!! Oh, my goodness! What did they pay for?\n", 3, ERRORLOG);
    mail('kelsangrinzin@gmail.com,rt@meditateinolympia.org', 'Cart not found', "Cart: $cartId\r\nPayer email: $_POST[payer_email]\r\nAmount: $_POST[mc_gross]\r\n");
}
error_log(print_r($cartArray, true)."\n", 3, ERRORLOG);
updateDBFromPurchase($transactionId, $cartArray);

error_log("End of paypalIPN.php\n\n", 3, ERRORLOG);
