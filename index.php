<?php
require_once 'utilities.php';

print_header("Simple Web");

$result = call_api("user_info");

do_when_success($result, function ($data) {
    $view_profile_page = SIMPLE_SITE_ROOT_URL . "view_profile/";
    $logout_page = SIMPLE_SITE_ROOT_URL . "logout/";
    echo "<h1>Hello, ${data['name']}</h1>";
    echo "<a href='${view_profile_page}'>View my profile</a><br />";
    echo "<a href='${logout_page}'>Log out</a>";
});

do_when_fail($result, function ($code, $message) {
    if ($code != ERROR_NOT_LOGGED_IN) {
        error_log("${code}: ${message}");

    } else {
        $login_page = SIMPLE_SITE_ROOT_URL . "login/";
        $register_page = SIMPLE_SITE_ROOT_URL . "register/";
        echo "<h1>You're not logged in</h1>";
        echo "<a href='${login_page}'>Log in</a><br />";
        echo "<a href='${register_page}'>Register</a>";
    }
});

print_footer();
