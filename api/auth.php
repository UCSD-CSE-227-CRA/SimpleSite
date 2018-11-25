<?php

require_once 'utilities.php';

/**
 * Check login credentials
 * @param mysqli $con Database connection
 * @return int User ID if logged in, -1 otherwise
 */
function check_login($con) {
    $sid = filter($con, $_POST["sid"]);
    $token = filter($con, $_POST["token"]);
    if (strlen($sid) == 0 || !is_random_string($sid, 32) || !is_random_string($token, 32)) {
        return -1;
    }

    $result = $con->query("SELECT * FROM session WHERE sid = '$sid' AND token = '$token'");
    check_sql_error($con);
    if (mysqli_affected_rows($con) > 0) {
        $result = mysqli_fetch_array($result);
        refresh_token($con, $result);
        return $result["userid"];
    } else {
        return -1;
    }
}

function refresh_token($con, $result) {
    $sid = $result["sid"];
    $raw_token = random_string(32);
    $token = md5($result["secret"] . $raw_token);
    $con->query("UPDATE session SET token = '$token' WHERE sid = '$sid'");
    check_sql_error($con);
    $GLOBALS['raw_token'] = $raw_token;
}
