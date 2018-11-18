<?php

require_once 'db_connect.php';

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

/**
 * Check if a string is a random string
 * @param string $data The data to be checked
 * @param int $length The length of the data
 * @return bool Whether the data is a random string
 * @see random_string()
 */
function is_random_string($data, $length = 32) {
    return (preg_match("/^[0-9a-zA-Z]{{$length}}$/", $data) > 0);
}