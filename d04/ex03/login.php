<?php
if (!session_start())
    return;

if ($_GET && $_GET['login'] != "" && $_GET['passwd'] != "") {
	$login = $_GET['login'];
	$passwd = $_GET['passwd'];
	include "auth.php";
	if (auth($login, $passwd))
	{
		$_SESSION['loggued_on_user'] = $login;
		echo "OK\n";
	}
	else
	{
		$_SESSION['loggued_on_user'] = "";
		echo "ERROR\n";
	}

}
