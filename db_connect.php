<?php
/**
 * Global shared lib for Simple Site.
 */
require_once 'config.php';

/**
 * Database connector.
 */
function db_connect() {
    $con = mysqli_connect(SIMPLE_SITE_DB_HOSTNAME, SIMPLE_SITE_DB_USERNAME, SIMPLE_SITE_DB_PASSWORD, SIMPLE_SITE_DB_NAME)
        or die("Database connection failed, check your 'config.php'!");
    $con->query("SET NAMES 'UTF8MB4'");
    return $con;
}
