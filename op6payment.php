<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Path to Bliss: Away Retreat at Ocean Park</title>
    <style>
        td {border: 1px gray solid; padding: 0 .5em;}
        table {border-collapse: collapse;}
        .reserved {color: gray;}
        .reserved:after {content: " Reserved";}
        div {float: left; margin-top: 1em;}
    </style>
</head>

<body>

    <h2>Step 6: Payment</h2>

    <p>You are registering for:</p>
    <form action="https://paypal.com" method="post">
            <table>
                <thead>
                    <tr><td>Name</td><td>Room</td><td>Age</td><td>Linens</td><td>Cost</td></tr>
                </thead>
                <tbody>
    <?php
        include("../../nonpublic/oceanpark/opDatabase.php");
        $attendee = [];
        $grandTotal = 0;
        foreach ($_POST as $key => $value) {
            if (substr($key, -9) === 'Firstname') {
                $root = substr($key, 0, -9);
                preg_match('/Bldg([0-9]*)Rm([0-9]*)Person([0-9]*)Firstname/', $key, $matches);
                $buildingID = $matches[1];
                $roomID     = $matches[2];
                $personID   = $matches[3];
                $linens     = array_key_exists($root.'Linens', $_POST) ? 'yes' : '';
                $cost       = $_POST[$root.'cost'];
                $grandTotal += $cost;
                echo <<<INDIVIDUALINFO
                    <tr>
                        <td>$value {$_POST[$root.'Lastname']}</td>
                        <td>{$buildings[$buildingID]['name']} {$rooms[$roomID]['roomNumber']}</td>
                        <td>{$_POST[$root.'Age']}</td>
                        <td>$linens</td>
                        <td>$$cost</td>
                    </tr>

INDIVIDUALINFO;
            }
        }            
        $deposit = sprintf("%01.2f", $grandTotal / 4);
        echo <<<TOTALS
                    <tr><td colspan='4' style='text-align:right;'>Grand Total </td><td>$$grandTotal</td></tr>
                </tbody>
            </table>
            <br>
            <select name="amount">
                <option value="$grandTotal">Full $$grandTotal</option>
                <option value="$deposit">25% Depost: $$deposit</option>
            </select>
            <p><input type='submit' value='Pay at PayPal' onclick='alert("This is not set up, yet.");'></p>
    </form>

TOTALS;

    echo "<pre>\n";
        //var_dump($_POST);
    echo "</pre>\n";
    ?>

</body>
</html>
