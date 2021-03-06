<?php

require_once 'utilities.php';

function contain_special_chars($data) {
    return (preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$data) > 0);
}

function is_email($data) {
    return ($data == filter_var($data, FILTER_VALIDATE_EMAIL));
}

$con = db_connect();

$name = filter($con, $_POST["name"], true);
$password = strtoupper(filter($con, $_POST["password"], true));
$sex = filter($con, $_POST["sex"]);
$email = filter($con, $_POST["email"], true);

if (!is_random_string($password, 64)) {
    report_error(ERROR_ILLEGAL_PARAMETER);
}

if (!($sex == "male" || $sex == "female" || $sex == "")) {
    report_error(ERROR_ILLEGAL_PARAMETER);
}

if (contain_special_chars($name)) {
    report_error(1, "Illegal user name");
}

if (strlen($name) < 3 || strlen($name) > 32) {
    report_error(2, "Length of user name should be between 3-32");
}

if (!is_email($email) || strlen($email) > 128) {
    report_error(3, "Illegal email");
}

$result = $con->query("SELECT * FROM user WHERE name = '$name'");
check_sql_error($con);
$result = mysqli_fetch_array($result);
if (mysqli_affected_rows($con) > 0) {
    report_error(4, "User name already registered");
}

$result = $con->query("SELECT * FROM user WHERE email = '$email'");
check_sql_error($con);
$result = mysqli_fetch_array($result);
if (mysqli_affected_rows($con) > 0) {
    report_error(5, "Email already registered");
}

$salt = random_string(6);
$hashed_password = sha256($password . $salt);
$con->query("INSERT INTO user (name, password, salt, sex, email) VALUES ('$name', '$hashed_password', '$salt', '$sex', '$email')");
check_sql_error($con);
report_success();
