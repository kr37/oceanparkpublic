<?php
include_once("../../../nonpublic/oceanpark/opBase.php");
include_once(NONPUBLIC_OP . "opDatabase.php");

// Create array where every row has all the columns
$allcolumns = []; $allkeys = []; $row = 0;
foreach($carts as $cart) {
    foreach ($cart['details'] as $key => $value) {
        $allkeys[$key] = '';
        $allcolumns[$row][$key] = $value;
    }
    $row++;
}
var_dump($allkeys);
var_dump($allcolumns);

// Output the array    
$out = fopen('php://output', 'w');
fputcsv($out, array_keys($allkeys));
foreach ($allcolumns as $row) {
    fputcsv($out, $row);
}
fclose($out);
