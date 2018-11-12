<?php
if (!session_start())
    return;
if ($_GET && $_GET['submit'] == 'OK') {
    $_SESSION['login'] = $_GET['login'];
    $_SESSION['passwd'] = $_GET['passwd'];
}
if ($_SESSION) {
    $login = $_SESSION['login'];
    $passwd = $_SESSION['passwd'];
}
?>
<html><body>
<form action="index.php" method="get" name="index.php">
    Username: <input type="text" name="login" value="<?php if ($login) echo $login ?>" />
    <br />
    Password: <input type="text" name="passwd" value="<?php if ($login) echo $passwd ?>" />
    <input type="submit" name="submit" value="OK" />
</form>
</body></html>
