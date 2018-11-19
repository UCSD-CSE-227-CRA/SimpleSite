<?php
require_once '../utilities.php';

print_header("Log In");
?>

<script>
    function do_submit() {
        let raw_password = document.getElementById("password").value;
        document.getElementById("password").value = md5(raw_password);
    }
</script>

<form action="do_login.php" method="post" onsubmit="do_submit()">
    Name: <input type="text" id="name" name="name" placeholder="User name or email"><br />
    Password: <input type="password" id="password" name="password" placeholder="Your password"><br />
    <button type="submit">Log In</button>
</form>

<?php
global $urls;

echo "<a href='${urls['main']}'>Go back</a>";

print_footer();
?>
