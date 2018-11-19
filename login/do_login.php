<?php
require_once '../utilities.php';

$result = call_api("login");

do_when_success($result, function ($data) {
    set_cookie('sid', $data['sid'], time() + 3600 * 24 * 7);
});

print_header("Log In Result");

do_when_success($result, function () {
    $main_page = url_for_path('');
    echo "<h1>Login Success!</h1>";
    echo "<a href='${main_page}'>Go back</a>";
});

do_when_fail($result, function ($code, $message) {
    $login_page = url_for_path("login");
    echo "<h1>Login Failed!</h1>";
    echo "<p>${message}</p>";
    echo "<a href='${login_page}'>Go back</a>";
});

print_footer();
