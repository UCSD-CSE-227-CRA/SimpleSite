<?php

/**
 * Config file for Simple Site.
 */
require_once 'config.php';

if (!SIMPLE_SITE_REPORT_ERRORS) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

//** Error codes. **//
define('ERROR_MISSING_PARAMETER', -1);
define('ERROR_ILLEGAL_PARAMETER', -2);
define('ERROR_NOT_LOGGED_IN', -3);
define('ERROR_SERVER_ERROR', -100);

/**
 * Database connector.
 * @return mysqli Database connection
 */
function db_connect() {
    $con = mysqli_connect(SIMPLE_SITE_DB_HOSTNAME, SIMPLE_SITE_DB_USERNAME, SIMPLE_SITE_DB_PASSWORD, SIMPLE_SITE_DB_NAME)
    or die("Database connection failed, check your 'config.php'!");
    $con->query("SET NAMES 'UTF8MB4'");
    return $con;
}
