<?php
require_once '../utilities.php';

$result = call_api("register");

print_header("Register Result");

do_when_success($result, function () {
    $login_page = SIMPLE_SITE_ROOT_URL . "login/";
    echo "<h1>Register Success!</h1>
<a href='${login_page}'>Log In Now</a>";
});

do_when_fail($result, function ($code, $message) {
    $register_page = SIMPLE_SITE_ROOT_URL . "register/";
    echo "<h1>Register Failed!</h1>
<p>${message}</p>
<a href='${register_page}'>Go Back</a>";
});

print_footer();
