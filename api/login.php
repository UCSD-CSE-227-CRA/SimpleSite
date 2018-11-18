<?php

require_once 'core.php';

$con = db_connect();
$name = filter($con, $_POST["name"]);
$email = filter($con, $_POST["email"]);
$password = filter($con, $_POST["password"], true);

if (strlen($name) == 0 && strlen($email) == 0) {
    report_error(ERROR_MISSING_PARAMETER);
}

if (!is_random_string($password, 32)) {
    report_error(ERROR_ILLEGAL_PARAMETER);
}

$result = null;
if (strlen($name) > 0) {
    $result = $con->query("SELECT * FROM user WHERE name = '$name'");
} else {
    $result = $con->query("SELECT * FROM user WHERE email = '$email'");
}
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

report_success(array("sid" => $sid));
