<?php
require_once '../utilities.php';

$result = call_api("login");

do_when_success($result, function ($data) {
    set_cookie('sid', $data['sid'], time() + 3600 * 24 * 7);
    set_cookie('secret', $data['secret'], 0);
});

print_header("Log In Result");

do_when_success($result, function () {
    global $urls;

    echo "<h1>Login Success!</h1>";
    echo "<a href='${urls['main']}'>Go back</a>";
});

do_when_fail($result, function ($code, $message) {
    global $urls;

    echo "<h1>Login Failed!</h1>";
    echo "<p>${message}</p>";
    echo "<a href='${urls['login']}'>Go back</a>";
});

print_footer();
