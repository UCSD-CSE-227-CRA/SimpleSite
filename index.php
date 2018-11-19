<?php
require_once 'utilities.php';

print_header("Simple Web");

$result = call_api("user_info");

do_when_success($result, function ($data) {
    $view_profile_page = url_for_path("view_profile");
    $logout_page = url_for_path("logout");
    echo "<h1>Hello, ${data['name']}</h1>";
    echo "<a href='${view_profile_page}'>View my profile</a><br />";
    echo "<a href='${logout_page}'>Log out</a>";
});

do_when_fail($result, function ($code, $message) {
    if ($code != ERROR_NOT_LOGGED_IN) {
        error_log("${code}: ${message}");
        echo "<p>${message}</p>";
    } else {
        $login_page = url_for_path("login");
        $register_page = url_for_path("register");
        echo "<h1>You're not logged in</h1>";
        echo "<a href='${login_page}'>Log in</a><br />";
        echo "<a href='${register_page}'>Register</a>";
    }
});

print_footer();
