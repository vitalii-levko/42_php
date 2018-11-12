<?php
if ($_POST && $_POST['submit'] == 'OK' && $_POST['login'] != "" &&  $_POST['oldpw'] != "" && $_POST['newpw'] != "") {
    $login = $_POST['login'];
    $oldpw = $_POST['oldpw'];
    $newpw = $_POST['newpw'];

    $file = "../private/passwd";
    $content = file_get_contents($file);
    $content = unserialize($content);
    $len = sizeof($content);
    for ($i = 0; $i < $len; $i++) {
    	if ($content[$i]['login'] == $login)
    	{
            $oldpw = hash('whirlpool', $oldpw);
            $usedpw = $content[$i]['passwd'];
            if ($oldpw != $usedpw)
            {
                echo "ERROR\n";
                return;
            }
            $newpw = hash('whirlpool', $newpw);
            $content[$i]['passwd'] = $newpw;
            $content = serialize($content);
            file_put_contents("../private/passwd", $content);
            echo "OK\n";
            return;
    	}
    }
    echo "ERROR\n";
}
else
	echo "ERROR\n";