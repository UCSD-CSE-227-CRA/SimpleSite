<?php
require_once '../utilities.php';

$result = call_api("login");

do_when_success($result, function ($data) {
    set_cookie('sid', $data['sid'], time() + 3600 * 24 * 7);
});

print_header("Log In Result");

do_when_success($result, function () {
    $main_page = SIMPLE_SITE_ROOT_URL;
    echo "<h1>Login Success!</h1>
<a href='${main_page}'>Go Back</a>";
});

do_when_fail($result, function ($code, $message) {
    $login_page = SIMPLE_SITE_ROOT_URL . "login/";
    echo "<h1>Login Failed!</h1>
<p>${message}</p>
<a href='${login_page}'>Go Back</a>";
});

print_footer();
