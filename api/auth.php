<?php

require_once 'utilities.php';

/**
 * Check login credentials
 * @param mysqli $con Database connection
 * @return int User ID if logged in, -1 otherwise
 */
function check_login($con) {
    $sid = filter($con, $_POST["sid"]);
    if (strlen($sid) == 0 || !is_random_string($sid, 32)) {
        return -1;
    }

    $result = $con->query("SELECT * FROM session WHERE sid = '$sid'");
    check_sql_error($con);
    if (mysqli_affected_rows($con) > 0) {
        return mysqli_fetch_array($result)["userid"];
    } else {
        return -1;
    }
}
