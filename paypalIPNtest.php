<?php
include("../../nonpublic/oceanpark/Paypal.php");

//var_dump($_POST);
?>
<form action="" method="post">
<input type='hidden' name='mc_gross' value='1.00'>
<input type='hidden' name='protection_eligibility' value='Eligible'>
<input type='hidden' name='address_status' value='confirmed'>
<input type='hidden' name='payer_id' value='BLQC5USM2WX2N'>
<input type='hidden' name='address_street' value='6556 24th Ave NW'>
<input type='hidden' name='payment_date' value='14:07:15 May 19, 2021 PDT'>
<input type='hidden' name='payment_status' value='Completed'>
<input type='hidden' name='charset' value='windows-1252'>
<input type='hidden' name='address_zip' value='98117'>
<input type='hidden' name='first_name' value='Michael'>
<input type='hidden' name='mc_fee' value='0.32'>
<input type='hidden' name='address_country_code' value='US'>
<input type='hidden' name='address_name' value='Michael Defever'>
<input type='hidden' name='notify_version' value='3.9'>
<input type='hidden' name='custom' value='2021-05-19T14:04:12-07:00rt@meditateinolympia.org'>
<input type='hidden' name='payer_status' value='verified'>
<input type='hidden' name='business' value='admin@meditateinolympia.org'>
<input type='hidden' name='address_country' value='United States'>
<input type='hidden' name='address_city' value='Seattle'>
<input type='hidden' name='quantity' value='1'>
<input type='hidden' name='verify_sign' value='AFFD9bJ.5qKThEaMLnYJA8XRw-XVACLLFGdMxHd55tDGFUSGi.OPWeXU'>
<input type='hidden' name='payer_email' value='kelsangrinzin@gmail.com'>
<input type='hidden' name='txn_id' value='2B571811FY625083C'>
<input type='hidden' name='payment_type' value='instant'>
<input type='hidden' name='last_name' value='Defever'>
<input type='hidden' name='address_state' value='WA'>
<input type='hidden' name='receiver_email' value='admin@meditateinolympia.org'>
<input type='hidden' name='payment_fee' value='0.32'>
<input type='hidden' name='shipping_discount' value='0.00'>
<input type='hidden' name='insurance_amount' value='0.00'>
<input type='hidden' name='receiver_id' value='GQPCQWGBS2GVY'>
<input type='hidden' name='txn_type' value='web_accept'>
<input type='hidden' name='item_name' value='Pathway to Bliss Weekend Retreat at Ocean Park'>
<input type='hidden' name='discount' value='0.00'>
<input type='hidden' name='mc_currency' value='USD'>
<input type='hidden' name='item_number' value='&residence_country=US'>
<input type='hidden' name='shipping_method' value='Default'>
<input type='hidden' name='transaction_subject' value='&payment_gross=1.00'>
<input type='hidden' name='ipn_track_id' value='c3df1fce20fe1'>
<input type='submit' name='submit' value='submit'>
</form>
<?php
$paypal = New Paypal;
$ppSuccess = $paypal->verifyIPN($_POST);

echo "<p>verifyIPN:</p>\n";
var_dump($ppSuccess);


