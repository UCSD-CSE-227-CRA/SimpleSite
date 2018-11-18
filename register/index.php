<?php
require_once '../utilities.php';

print_header("Register");
?>

<script>
    function do_submit() {
        let raw_password = document.getElementById("password").value;
        document.getElementById("password").value = md5(raw_password);
    }
</script>

<form action="do_register.php" method="post" onsubmit="do_submit()">
    User Name: <input type="text" id="name" name="name" placeholder="Your user name" minlength="3" maxlength="32"><br />
    Password: <input type="password" id="password" name="password" placeholder="Your password" minlength="5"><br />
    Sex: <select name="sex">
        <option value="">Other</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select><br />
    Email: <input type="text" id="email" name="email" placeholder="Your email"><br />
    <button type="submit">Register</button>
</form>

<?php
$main_page = SIMPLE_SITE_ROOT_URL;
echo "<a href='${main_page}'>Go back</a>";

print_footer();
?>
