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

    <h2>Step 3: Choose rooms</h2>
    <p>Due to the pandemic, we are not required to fill the rooms. You may have as few as one person in any room.</p>

    <?php

    include("opDatabase.php");

    if (array_key_exists('command', $_GET)) {
        switch ($_GET['command']) {
            case 'getBuildingsAndRooms': echo json_encode([$buildings, $rooms]); break;
        }
    }

    ?>
    <form id="registrationForm" action="op4names.php" method="get">
        <input type="submit" value="Next">
        <?php foreach($_GET as $key => $value) echo "        <input type='hidden' name='$key' value='$value'>\n"; ?>
        <table>
        <tbody>
    <?php
    foreach ($buildings as $building) {
        $roomIDs = str_getcsv($building['roomIDs']);
        echo "            <tr><td colspan='3'>$building[description]</td></tr>\n";
        echo "            <tr><td>Room</td><td>Beds</td><td>Description</td>\n";
        foreach ($roomIDs as $id) {
            $roomNumber = $rooms[$id]['roomNumber'];
            echo <<<ROOMS
                <tr>
                    <td><input id='room$id' name='room$id' type='checkbox'>$building[name] Room $roomNumber</td>
                    <td>{$rooms[$id]['beds']}</td>
                    <td>{$rooms[$id]['description']}</td>
                </tr>\n
ROOMS;
        }
    }
    ?>
        </tbody>
        </table>
    </form>


<?php
/*
CREATE TABLE `attendees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `registrantID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `isChild` tinyint(1) NOT NULL COMMENT '0=No, 1=Yes',
  `carers` text NOT NULL,
  `address` text NOT NULL,
  `emergencyContact` text NOT NULL,
  `allergiesAndHealth` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `roomIDs` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `registrants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `phone` tinytext NOT NULL,
  `center` tinytext NOT NULL,
  `transactions` text NOT NULL,
  `totalCost` decimal(6,2) NOT NULL,
  `stillToPay` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buildingID` int(11) NOT NULL,
  `roomNumber` varchar(30) NOT NULL,
  `beds` int(11) NOT NULL,
  `description` text NOT NULL,
  `attendeeIDs` tinytext NOT NULL,
  `fullyBooked` tinyint(1) NOT NULL COMMENT '0=No, 1=Yes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `variousData` (
  `name` tinytext NOT NULL,
  `data` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ascii;


CREATE TABLE `xref_buildings2rooms` (
  `buildingID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

*/
?>
    <pre>
    <?php
        var_dump($_GET);
    ?>
    </pre>

</body>
</html>
