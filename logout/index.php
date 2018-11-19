<?php
require_once '../utilities.php';

$result = call_api("logout");

do_when_success($result, function ($data) {
    set_cookie('sid', '', time() - 3600);
});

print_header("Log Out Result");

do_when_success($result, function () {
    $main_page = url_for_path('');
    echo "<h1>Logout Success!</h1>";
    echo "<a href='${main_page}'>Go back</a>";
});

do_when_fail($result, function ($code, $message) {
    $main_page = url_for_path('');
    echo "<h1>Logout Failed!</h1>";
    echo "<p>${message}</p>";
    echo "<a href='${main_page}'>Go back</a>";
});

print_footer();
