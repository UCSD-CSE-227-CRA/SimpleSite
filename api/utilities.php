<?php

require_once '../commons.php';

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
    echo json_encode(["code" => $code, "message" => $message]);
    exit();
}

/**
 * Report success message and data to the client, add raw token if present
 * @param array $data Data to return
 */
function report_success($data = null) {
    $data = $data ? $data : [];
    $raw_token = $GLOBALS['raw_token'];
    if (strlen($raw_token) > 0) {
        $data = array_merge($data, ['raw_token' => $raw_token]);
    }
    echo json_encode(["code" => 0, "data" => $data]);
}

/**
 * Get the sha256 hashed info in upper case
 * @param string $info The info to hash
 * @return string The hashed info
 */
function sha256($info) {
    return strtoupper(hash("sha256", $info));
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
