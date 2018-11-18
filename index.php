<?php
require_once 'utilities.php';

print_header("Simple Web");

call_api("user_info", null,
    function ($data) {
        echo "<h1>Hello, ${data['name']}</h1>";
        echo "<a href='logout'>Log out</a>";
    },
    function ($code, $message) {
        echo "<h1>You're not logged in</h1>";
        echo "<a href='login'>Log in</a>";
        echo "<a href='register'>Register</a>";
    });

print_footer();
