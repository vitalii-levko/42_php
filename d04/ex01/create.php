<?php
if ($_POST && $_POST['submit'] == 'OK' && $_POST['login'] != "" && $_POST['passwd'] != "") {
    $login = $_POST['login'];
    $passwd = $_POST['passwd'];

    if (!file_exists("../private"))
    	mkdir("../private/");
    $file = "../private/passwd";
    if (file_exists($file))
    {
    	$content = unserialize(file_get_contents($file));
        foreach ($content as $item) {
        	if ($item['login'] == $login)
        	{
        		echo "ERROR\n";
        		return;
        	}
        }
    }
   	$content[] = array(
		"login" => $login,
		"passwd" => hash('whirlpool', $passwd)
	);
	
	$content = serialize($content);
	file_put_contents("../private/passwd", $content);
    echo "OK\n";
}
else
	echo "ERROR\n";