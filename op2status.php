<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Path to Bliss: Away Retreat at Ocean Park</title>
    <style>
        td {border: 1px gray solid;}
        table {border-collapse: collapse; margin:auto;}
        .reserved {color: gray;}
        .reserved:after {content: " Reserved";}
    </style>
</head>

<body>

    <h2>Step 2: Status</h2>

    <?php
    if (!array_key_exists('email', $_GET)) {
        echo "<p>Please click back on your browser, and enter an email.</p>\n<meta http-equiv='refresh' content='3;url=index.php'>";
    } else {
        $email = $_GET['email'];
        include("../../nonpublic/oceanpark/opDatabase.php");
        $registrant = null;
        foreach ($registrants as $registrant) //Search for this email among previous registrations
            if ($email == $registrant.email)
                break;
        if ($registrant == null) {
            echo <<<NOTREGISTERED
                <p>It looks like you haven't registered yet.</p>
                <p>Later, after you've registered, if you come back here, you can view your registration and pay any remaining balance.<p>
                <form action='op3chooseRooms.php' method='get'>
                    <input type='hidden' name='email' value='$email'>
                    <input type='submit' value='next'>
                </form>
NOTREGISTERED;
        } else {
            echo "<p>This hasn't been implemented, yet. In the future, you would see your registration details, and you would have options, such as paying any balance.</p>\n";
        }
    }
    ?>

</body>
</html>
