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
    $user = create_user();
} else {
    $user = query("SELECT * FROM User WHERE session_identifier = ?", $_COOKIE['session_identifier']);
    if (empty($user)) {
        $user = create_user();
    }
}

?>
