<?php

require_once 'utilities.php';

$con = db_connect();
$name = filter($con, $_POST["name"], true);
$password = filter($con, $_POST["password"], true);

if (!is_random_string($password, 32)) {
    report_error(ERROR_ILLEGAL_PARAMETER);
}

$result = $con->query("SELECT * FROM user WHERE name = '$name' or email = '$name'");
check_sql_error($con);
if (mysqli_affected_rows($con) == 0) {
    report_error(1, "User name or password incorrect");
}

$result = mysqli_fetch_array($result);
if (md5_password($password, $result["salt"]) != strtoupper($result["password"])) {
    report_error(1, "User name or password incorrect");
}

$sid = null;
$userid = $result["userid"];
do {
    $sid = random_string(32);
    $con->query("SELECT * FROM session WHERE sid = '$sid'");
    check_sql_error($con);
} while (mysqli_affected_rows($con) > 0);

$con->query("INSERT INTO session (sid, userid, secret, token) VALUES ('$sid', '$userid', 'N/A', 'N/A')");
check_sql_error($con);

report_success(["sid" => $sid]);
