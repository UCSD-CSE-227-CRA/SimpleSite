<?php
require_once '../utilities.php';

print_header("View Profile");

$result = call_api("user_info");

do_when_success($result, function ($data) {
    $main_page = SIMPLE_SITE_ROOT_URL;
    echo "<p>User name: ${data['name']}</p>";
    echo "<p>Sex: ${data['sex']}</p>";
    echo "<p>Email: ${data['email']}</p>";
    echo "<a href='${main_page}'>Go back</a>";
});

do_when_fail($result, function ($code, $message) {
    if ($code != ERROR_NOT_LOGGED_IN) {
        error_log("${code}: ${message}");
        echo "<p>${message}</p>";
    } else {
        $main_page = SIMPLE_SITE_ROOT_URL;
        echo "<h1>You're not logged in</h1>";
        echo "<a href='${main_page}'>Go back</a>";
    }
});

print_footer();
