<?php

require_once 'utilities.php';
require_once 'auth.php';

$con = db_connect();

$userid = check_login($con);
if ($userid < 0) {
    report_error(ERROR_NOT_LOGGED_IN);
}

$name = filter($con, $_POST["name"]);
$result = null;
if (strlen($name) > 0) {
    $result = $con->query("SELECT * FROM user WHERE name = '" . $name . "'");
} else {
    $result = $con->query("SELECT * FROM user WHERE userid = '" . $userid . "'");
}
check_sql_error($con);

if (mysqli_affected_rows($con) == 0) {
    report_error(1, "User does not exist");
}

$result = mysqli_fetch_array($result);
$return = array(
    "name" => $result["name"],
    "sex" => $result["sex"],
);
if ($userid == $result["userid"]) {
    $return["email"] = $result["email"];
}

report_success($return);
