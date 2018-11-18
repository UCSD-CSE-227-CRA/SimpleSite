<?php

require_once '../db_connect.php';

//** Error codes. **//
define('ERROR_MISSING_PARAMETER', -1);
define('ERROR_ILLEGAL_PARAMETER', -2);
define('ERROR_NOT_LOGGED_IN', -3);
define('ERROR_SERVER_ERROR', -100);

/**
 * Filter and check the data to prevent SQL injection
 * @param mysqli $con Database connection
 * @param string $data The data to be filtered
 * @param bool $required Whether the parameter is required
 * @param bool $report_error Whether php should report potential injection
 * @return string Filtered data
 */
function filter($con, $data, $required = false, $report_error = true) {
    if ($required && strlen($data) == 0) {
        report_error(ERROR_MISSING_PARAMETER);
    }
    $safe_data = mysqli_real_escape_string($con, $data);
    if ($report_error && $data != $safe_data) {
        report_error(ERROR_ILLEGAL_PARAMETER);
    }
    return $safe_data;
}

/**
 * Check whether there is SQL error with current connection
 * @param mysqli $con Database connection
 */
function check_sql_error($con) {
    if (mysqli_error($con)) {
        $message = "";
        if (SIMPLE_SITE_REPORT_ERRORS) {
            $message = mysqli_error($con);
        }
        report_error(ERROR_SERVER_ERROR, $message);
    }
}

/**
 * Report an error to the client
 * @param int $code Error code
 * @param string $message Error message
 */
function report_error($code, $message = "") {
    if (strlen($message) == 0) {
        switch ($code) {
            case ERROR_MISSING_PARAMETER:
                $message = "Missing parameter";
                break;
            case ERROR_ILLEGAL_PARAMETER:
                $message = "Illegal parameter";
                break;
            case ERROR_NOT_LOGGED_IN:
                $message = "Not logged in";
                break;
            case ERROR_SERVER_ERROR:
                $message = "Server error";
                break;
            default:
                $message = "Unknown error";
                break;
        }
    }
    echo json_encode(array("code" => $code, "message" => $message));
    exit();
}

/**
 * Report success message and data to the client
 * @param mixed $data Data to return
 */
function report_success($data = null) {
    echo json_encode(array("code" => 0, "data" => $data));
}

/**
 * Get the encrypted password from salt
 * @param string $password The password to convert
 * @param string $salt The password salt
 * @return string The converted password
 */
function md5_password($password, $salt) {
    return strtoupper(md5(strtoupper($password) . $salt));
}

/**
 * Generate a random string consisting of numbers and letters
 * @param int $length Length of the random string
 * @return string The generated random string
 */
function random_string($length) {
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
function is_random_string($data, $length) {
    return (preg_match("/^[0-9a-zA-Z]{{$length}}$/", $data) > 0);
}
