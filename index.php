<?php

require_once 'utilities.php';

call_api("/api/user_info.php", [],
    function ($data) {
        echo "<h1>Hello, ${data['name']}</h1>";
    },
    function ($code, $message) {
        echo "<a href='login'>Please log in</a>";
    });
