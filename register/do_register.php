<?php
require_once '../utilities.php';

$result = call_api("register");

print_header("Register Result");

do_when_success($result, function () {
    $login_page = SIMPLE_SITE_ROOT_URL . "login/";
    echo "<h1>Register Success!</h1>";
    echo "<a href='${login_page}'>Log in now</a>";
});

do_when_fail($result, function ($code, $message) {
    $register_page = SIMPLE_SITE_ROOT_URL . "register/";
    echo "<h1>Register Failed!</h1>";
    echo "<p>${message}</p>";
    echo "<a href='${register_page}'>Go back</a>";
});

print_footer();
