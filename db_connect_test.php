<?php

require_once 'utilities.php';

print_header("Database connection test");

echo "<h1>";

if (!mysqli_error(db_connect())) {
    echo "Database connection success!";
}else {
    echo "Database connection failed!";
}

echo "</h1>";

print_footer();
