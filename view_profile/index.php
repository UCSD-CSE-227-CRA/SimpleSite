<?php
require_once '../utilities.php';

print_header("View Profile");

$result = call_api("user_info");

do_when_success($result, function ($data) {
    global $urls;

    echo "<p>User name: ${data['name']}</p>";
    echo "<p>Sex: ${data['sex']}</p>";
    echo "<p>Email: ${data['email']}</p>";
    echo "<a href='${urls['main']}'>Go back</a>";
});

do_when_fail($result, function ($code, $message) {
    global $urls;

    if ($code != ERROR_NOT_LOGGED_IN) {
        error_log("${code}: ${message}");
        echo "<p>${message}</p>";
    } else {
        echo "<h1>You're not logged in</h1>";
        echo "<a href='${urls['main']}'>Go back</a>";
    }
});

print_footer();
