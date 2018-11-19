<?php
require_once '../utilities.php';

$result = call_api("register");

print_header("Register Result");

do_when_success($result, function () {
    global $urls;

    echo "<h1>Register Success!</h1>";
    echo "<a href='${urls['login']}'>Log in now</a>";
});

do_when_fail($result, function ($code, $message) {
    global $urls;

    echo "<h1>Register Failed!</h1>";
    echo "<p>${message}</p>";
    echo "<a href='${urls['register']}'>Go back</a>";
});

print_footer();
