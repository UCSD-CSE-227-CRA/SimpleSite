<?php
require_once 'utilities.php';

print_header("Simple Web");

$result = call_api("user_info");

do_when_success($result, function ($data) {
    echo "<h1>Hello, ${data['name']}</h1>";
    echo "<a href='logout'>Log out</a>";
});

do_when_fail($result, function ($code, $message) {
    if ($code != ERROR_NOT_LOGGED_IN) {
        error_log("${code}: ${message}");

    } else {
        echo "<h1>You're not logged in</h1>";
        echo "<a href='login'>Log in</a><br />";
        echo "<a href='register'>Register</a>";
    }
});

print_footer();
