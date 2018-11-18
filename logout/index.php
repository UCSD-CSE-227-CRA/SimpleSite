<?php
require_once '../utilities.php';

$result = call_api("logout");

do_when_success($result, function ($data) {
    set_cookie('sid', '', time() - 3600);
});

print_header("Log Out Result");

do_when_success($result, function () {
    $main_page = SIMPLE_SITE_ROOT_URL;
    echo "<h1>Logout Success!</h1>
<a href='${main_page}'>Go Back</a>";
});

do_when_fail($result, function ($code, $message) {
    $main_page = SIMPLE_SITE_ROOT_URL;
    echo "<h1>Logout Failed!</h1>
<p>${message}</p>
<a href='${main_page}'>Go Back</a>";
});

print_footer();
