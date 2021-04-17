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

    <h2>Step 5: Personal information</h2>

    <form action="op6payment.php" method="get">
        <?php foreach($_GET as $key => $value) echo "        <input type='hidden' name='$key' value='$value'>\n"; ?>
        <input type="submit" value="Next"></p>
        <fieldset>
            <p>Please tell us about you.</p>
            <label for='registrantName'>What is your name?</label>
            <input type="text" name='registrantName'><br>
            <label for='registrantPhone'>What is your phone number?</label>
            <input type="tel" name='registrantPhone'><br>
            <label for='registrantCenter'>If you attend an NKT Center, which one?</label>
            <input type="text" name='registrantCenter'><br>
        </fieldset>

        <fieldset>
            <legend>Everyone in your group</legend>
            <p>For insurance purposes, Ocean Park Camp requires the following information for all the people in your group.</p>
            <p>Regarding food allergies and dietary restrictions, we would like to accommodate, and will let you know in advance.</p>
            <?php
            foreach ($_GET as $key => $value) {
                if (substr($key, -9) === 'Firstname') {
                    $root = substr($key, 0, -9);
                    echo <<<INDIVIDUALINFO
            <fieldset>
                <legend>$value {$_GET[$root.'Lastname']}</legend>
                <div><label for='{$root}address'>Home address</label><br>
                    <textarea rows='5' cols='37' name='{$root}address'></textarea></div>
                <div><label for='{$root}emergencyContact'>Emergency contact (name and phone of someone off-site)</label><br>
                    <input type='text' size='50' name='{$root}emergencyContact'></textarea></div>
                <div><label for='{$root}food'>Food allergies or dietary restrictions</label><br>
                    <textarea rows='5' cols='37' name='{$root}food'></textarea></div>
                <div><label for='{$root}medical'>Please list any medical conditions or medications we should know about to help you.</label><br>
                    <textarea rows='5' cols='37' name='{$root}medical'></textarea></div>
            </fieldset>

INDIVIDUALINFO;
                }
            }            
            ?>
            <p><label for='anything'><strong>Is there anything else you wish to convey to us?</strong></label><br>
                <textarea rows='5' cols='37' name='anything'></textarea></p>
        </fieldset>
    </form>
    <pre>
    <?php
        var_dump($_GET);
    ?>
    </pre>

</body>
</html>
