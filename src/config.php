<?php

// display errors, warnings, and notices
ini_set("display_errors", true);
error_reporting(E_ALL);

// requirements
require("constants.php");
require("functions.php");

// enable sessions
session_start();

if (empty($_COOKIE['session_identifier'])) {
    srand(time());
    $random_number = rand();
    $session_identifier = sha1($random_number);
    insert_or_update("INSERT INTO User (session_identifier) VALUES (?)", $session_identifier);
    setcookie('session_identifier', $session_identifier, time()+60*60*24*30);
    $user = query("SELECT * FROM User WHERE session_identifier = ?", $session_identifier);
} else {
    $user = query("SELECT * FROM User WHERE session_identifier = ?", $_COOKIE['session_identifier']);
}

?>
