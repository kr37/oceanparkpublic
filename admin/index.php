<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Path to Bliss: Away Retreat at Ocean Park</title>
    <style>
        table, th, td {border: 1px gray solid; border-collapse: collapse;}
        th {text-align: left;}
    </style>
</head>

<body>

    <p>Download <a href="carts.csv.php" download="carts.csv">carts.csv</a></p>

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
                echo "$s      <td>$column</td>\n";
            }
            echo "$s   </tr>\n";
        }
        echo <<<TABLE
            </tbody>
        </table>
TABLE;
    }

    foreach ($registrants as &$registrant) unset($registrant['totalCost'], $registrant['stillToPay']);
    table ('Registrants',
            $registrants, 
            ['Email', 'Name', 'Phone', 'Center', 'Transactions', 'Carts']);

    table('Transactions',
            $transactions, 
            ['Registrant email', 'Email at PayPal', 'Cart ID', 'txn_id', 'Paid', 'Cart Total', 'All PayPal fields']);

    table('Carts',
            $carts, 
            ['Creation time', 'Registrant email', 'Total', 'Paid', 'Due', 'Transaction IDs', 'All the cart data']);

    foreach ($attendees as &$att) unset($att['isChild'], $att['carers']);
    table('Attendees',
            $attendees, 
            ['Attendee name', 'Registrant email', 'Room ID', 'Linens (1=yes)', 'Cost', 'Address', 'Emergency contact', 'Food', 'Medical']);
    ?>

</body>
</html>
