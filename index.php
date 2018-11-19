<?php
require_once 'utilities.php';

print_header("Simple Web");

$result = call_api("user_info");

do_when_success($result, function ($data) {
    global $urls;

    echo "<h1>Hello, ${data['name']}</h1>";
    echo "<a href='${urls['view_profile']}'>View my profile</a><br />";
    echo "<a href='${urls['logout']}'>Log out</a>";
});

do_when_fail($result, function ($code, $message) {
    global $urls;

    if ($code != ERROR_NOT_LOGGED_IN) {
        error_log("${code}: ${message}");
        echo "<p>${message}</p>";
    } else {
        echo "<h1>You're not logged in</h1>";
        echo "<a href='${urls['login']}'>Log in</a><br />";
        echo "<a href='${urls['register']}'>Register</a>";
    }
});

print_footer();
