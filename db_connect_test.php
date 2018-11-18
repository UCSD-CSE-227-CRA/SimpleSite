<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Database connection test</title>
</head>

<body>
    <h1 align="center">
    <?php
    require_once "db_connect.php";
    if (!mysqli_error(db_connect())) {
        echo "Database connection success!";
    }else {
        echo "Database connection failed!";
    }
    ?>
    </h1>
</body>

</html>
