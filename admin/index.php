<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Path to Bliss: Away Retreat at Ocean Park</title>
    <style>
        table, th, td {border: 1px gray solid; border-collapse: collapse;}
        th {text-align: left;}
        .tiny {font-size: 6pt;}
    </style>
</head>

<body>

    <!--p>Download <a href="carts.csv.php" download="carts.csv">carts.csv</a></p-->

    <?php
    include_once("../../../nonpublic/oceanpark/opBase.php");
    include_once(NONPUBLIC_OP . "opDatabase.php");

    function table($title, $array, $headers=[]) {
        ksort($array, SORT_NATURAL); 
        $s = '         ';
        echo "      <h2>$title</h2>\n";
        echo "      <table>\n";
        if (count($headers)) {
            echo "$s<thead>\n";
            echo "$s   <tr>\n";
            echo "$s      <th>ID</th>\n";
            foreach ($headers as $header) 
                echo "$s      <th>$header</th>\n";
            echo "$s   </tr>\n";
            echo "$s</thead>\n";
        }
        echo "$s<tbody>\n";
        foreach ($array as $id => $row) {
            echo "$s   <tr>$s      <td>$id</td>\n";
            foreach ($row as $column) {
                if (is_array($column)) $column = implode(',', $column);
                $class = strlen($column) > 50 ? ' class="tiny"' : '';
                echo "$s      <td$class>$column</td>\n";
            }
            echo "$s   </tr>\n";
        }
        echo <<<TABLE
            </tbody>
        </table>
TABLE;
    }

    // Make a nice array for the rooms allocation
    $total = 0; $j = 0;
    $rm = [];
    foreach ($attendees as $attendee) {
        $j++;
        $roomID = $attendee['roomID']; 
        $i = $roomID.$j;
        if ($roomID === 'tent' or $roomID === 'rv') {
            $rm[$i]['room']   = $roomID;
            $linens           = 'n/a';
        } else {
            $rm[$i]['room']   = $buildings[$rooms[$roomID]['buildingID']][name] . ' ' . $rooms[$roomID]['roomNumber'];
            $linens           = $attendee['linens'] ? 'Yes' : '';
        }
        $rm[$i]['name']    = $attendee['name'];
        $rm[$i]['linens']  = $linens;
        $rm[$i]['cost']    = $attendee['cost'];
        $rm[$i]['address'] = $attendee['address'];
        $rm[$i]['contact'] = $attendee['emergencyContact'];
        $rm[$i]['food']    = $attendee[vegan] . ($attendee['food'] ? ": $attendee[food]" : '');
        $rm[$i]['medical'] = $attendee['medical'];
        $total += $cost;
    }   
    $grandTotal = number_format($total, 2);

    table('Rooms', 
            $rm, 
            ['Room', 'Name', 'Linens', 'Cost', 'Address', 'Emergency contact', 'Food', 'Medical']);

    //Clean up the registrants table, then output.
    foreach ($registrants as &$registrant) 
        unset($registrant['totalCost'], $registrant['stillToPay']);
    table('Registrants',
            $registrants, 
            ['Email', 'Name', 'Phone', 'Center', 'Transactions', 'Carts']);

    table('Transactions',
            $transactions, 
            ['Registrant email', 'Email at PayPal', 'Cart ID', 'txn_id', 'Paid', 'Cart Total', 'All PayPal fields']);

    foreach ($carts as &$cart) unset($cart['details']);
    table('Carts',
            $carts, 
            ['Creation time', 'Registrant email', 'Total', 'Paid', 'Due', 'Transaction IDs', 'All the cart data']);

    ?>

</body>
</html>

