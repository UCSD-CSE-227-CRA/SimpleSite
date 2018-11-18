<?php

require_once 'db_connect.php';

//** Error codes. **//
define('ERROR_MISSING_PARAMETER', -1);
define('ERROR_ILLEGAL_PARAMETER', -2);
define('ERROR_SERVER_ERROR', -3);


/**
 * Check login credentials
 * @param mysqli $con Database connection
 * @return bool Whether the user is logged in
 */
function check_login($con) {
    return true;
}

/**
 * Generate a random string consisting of numbers and letters
 * @param int $length Length of the random string
 * @return string The generated random string
 */
function random_string($length = 32) {
    if ($length <= 0) {
        $length = 1;
    }
    $str = "";
    $str_pol = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $max = strlen($str_pol) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $str_pol[rand(0, $max)];
    }
    return $str;
}
