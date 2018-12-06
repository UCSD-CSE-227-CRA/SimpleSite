<?php

require_once 'utilities.php';

$con = db_connect();
$name = filter($con, $_POST["name"], true);
$password = strtoupper(filter($con, $_POST["password"], true));

if (!is_random_string($password, 64)) {
    report_error(ERROR_ILLEGAL_PARAMETER);
}

$result = $con->query("SELECT * FROM user WHERE name = '$name' or email = '$name'");
check_sql_error($con);
if (mysqli_affected_rows($con) == 0) {
    report_error(1, "User name or password incorrect");
}

$result = mysqli_fetch_array($result);
if (sha256($password . $result["salt"]) != $result["password"]) {
    report_error(1, "User name or password incorrect");
}

$sid = null;
$userid = $result["userid"];
$raw_token = random_string(32);
$secret = random_string(32);
$token = sha256($secret . $raw_token);
do {
    $sid = random_string(32);
    $con->query("SELECT * FROM session WHERE sid = '$sid'");
    check_sql_error($con);
} while (mysqli_affected_rows($con) > 0);

$con->query("INSERT INTO session (sid, userid, secret, token) VALUES ('$sid', '$userid', '$secret', '$token')");
check_sql_error($con);

$GLOBALS['raw_token'] = $raw_token;
report_success(["sid" => $sid, "secret" => $secret]);
