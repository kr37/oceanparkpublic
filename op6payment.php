<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Path to Bliss: Away Retreat at Ocean Park</title>
    <style>
        td {border: 1px gray solid;}
        table {border-collapse: collapse;}
        .reserved {color: gray;}
        .reserved:after {content: " Reserved";}
        div {float: left; margin-top: 1em;}
    </style>
</head>

<body>

    <h2>Step 6: Payment</h2>

    <p>You are registering for:</p>
    <form action="https://paypal.com" method="get">
            <table>
                <thead>
                    <tr><td>Name</td><td>Room</td><td>Age</td><td>Linens</td><td>Cost</td></tr>
                </thead>
                <tbody>
    <?php
        include("../../nonpublic/oceanpark/opDatabase.php");
        $attendee = [];
        foreach ($_GET as $key => $value) {
            if (substr($key, -9) === 'Firstname') {
                $root = substr($key, 0, -9);
                preg_match('/Bldg([0-9]*)Rm([0-9]*)Person([0-9]*)Firstname/', $key, $matches);
                $buildingID = $matches[1];
                $roomID     = $matches[2];
                $personID   = $matches[3];
                $linens     = array_key_exists($root.'Linens', $_GET) ? 'yes' : '';
                echo <<<INDIVIDUALINFO
                    <tr>
                        <td>$value {$_GET[$root.'Lastname']}</td>
                        <td>{$buildings[$buildingID]['name']} {$rooms[$roomID]['roomNumber']}</td>
                        <td>{$_GET[$root.'Age']}</td>
                        <td>$linens</td>
                        <td></td>
                    </tr>

INDIVIDUALINFO;
            }
        }            
        ?>
                </tbody>
            </table>
    </form>
    <pre>
    <?php
        var_dump($_GET);
    ?>
    </pre>

</body>
</html>
