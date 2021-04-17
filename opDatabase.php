<?php

// Open Database
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("localhost", "rinzin", "ocean21park37!", "ocean_park");
  $mysqli->set_charset("utf8_general_ci");
} catch(Exception $e) {
  error_log($e->getMessage());
  exit('Error connecting to database');
}

function arrayFromDB($mysqli, $table) {
    $query = $mysqli->query("SELECT * FROM $table");
    $array = [];
    while ($row = $query->fetch_assoc()) {
        $id = $row['id']; unset($row['id']);
        $array[$id] = $row;
    }
    return $array;
}

// Pull data from DB
$buildings   = arrayFromDB($mysqli, 'buildings');
$rooms       = arrayFromDB($mysqli, 'rooms');
$registrants = arrayFromDB($mysqli, 'registrants');
$attendees   = arrayFromDB($mysqli, 'attendees');

