<?php

require_once 'core.php';
require_once 'auth.php';

$con = db_connect();

$userid = check_login($con);
if ($userid < 0) {
    report_error(ERROR_NOT_LOGGED_IN);
}

$sid = filter($con, $_REQUEST["sid"], true);

$con->query("DELETE FROM session WHERE sid = '$sid'");
check_sql_error($con);

report_success();