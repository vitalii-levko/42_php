<?php
if ($_GET["action"] == "set")
	@setcookie($_GET["name"], $_GET["value"], time()+3600);
elseif ($_GET["action"] == "get")
{
	$c = 0;
	@$c = $_COOKIE[$_GET["name"]];
	if ($c)
		echo $c."\n";
}
elseif ($_GET["action"] == "del")
	@setcookie($_GET["name"], "", time()-3600);
