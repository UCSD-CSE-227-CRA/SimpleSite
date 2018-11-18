<?php

require_once 'core.php';
require_once 'auth.php';

$con = db_connect();

if (check_login($con) < 0) {
    report_error(ERROR_NOT_LOGGED_IN);
}

$sid = filter($con, $_POST["sid"], true);

$con->query("DELETE FROM session WHERE sid = '$sid'");
check_sql_error($con);

report_success();