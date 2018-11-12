<?php
function auth($login, $passwd)
{
    $file = "../private/passwd";
    if (!file_exists("../private") || !file_exists($file))
    	return (false);
	$content = unserialize(file_get_contents($file));
    foreach ($content as $item) {
    	if ($item['login'] == $login)
    	{
	    	if ($item['passwd'] == hash('whirlpool', $passwd))
    			return true;
    		else
    			return false;
		}
	}
	return false;
}
