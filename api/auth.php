<?php

require_once 'utilities.php';

/**
 * Check login credentials and refresh the token
 * @param mysqli $con Database connection
 * @return int User ID if logged in, -1 otherwise
 */
function check_login($con) {
    $sid = filter($con, $_POST["sid"]);
    $token = filter($con, $_POST["token"]);
    $info = filter($con, $_POST["info"]); // Correspond to "url" field in front end
    $info_encrypted = filter($con, $_POST["info_encrypted"]); // Correspond to "url_encrypted" field in front end
    if (strlen($sid) == 0 || !is_random_string($sid, 32) || !is_random_string($token, 32)
        || strlen($info) == 0 || !is_random_string($info_encrypted, 32) || $info_encrypted === $token) {
        return -1;
    }

    // Check whether the session ID and token is matched
    $result = $con->query("SELECT * FROM session WHERE sid = '$sid' AND token = '$token'");
    check_sql_error($con);
    if (mysqli_affected_rows($con) > 0) {
        $result = mysqli_fetch_array($result);
        $secret = $result['secret'];

        // Check whether the info and encrypted info is matched
        if (md5($secret . $token . $info) != $info_encrypted) {
            return -1;
        }

        // Generate a new token for current session
        $raw_token = random_string(32);
        $token = md5($secret . $raw_token);
        $con->query("UPDATE session SET token = '$token' WHERE sid = '$sid'");
        check_sql_error($con);
        $GLOBALS['raw_token'] = $raw_token;

        return $result["userid"];
    } else {
        return -1;
    }
}
