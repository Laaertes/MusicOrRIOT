<?php

/**
 * config.php
 *
 * Computer Science 50
 * Problem Set 7
 *
 * Configures pages.
 */

// display errors, warnings, and notices
ini_set("display_errors", true);
error_reporting(E_ALL);

// requirements
require("constants.php");
require("functions.php");

// enable sessions
session_start();

/*
*
*We need this at the end
// require authentication for most pages
if (!preg_match("{(?:landing)\.php$}", $_SERVER["PHP_SELF"]))
{
    if (empty($_COOKIE["id"]))
    {
        redirect("index.php");
    }
}*/

?>
