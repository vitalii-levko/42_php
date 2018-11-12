<?php
header('HTTP/1.0 401 Unathorized');
$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];
if (!($user == "zaz" && $pass == "jaimelespetitsponeys")) {
    header("WWW-Authenticate: Basic realm=''Member Area''");
    header('HTTP/1.0 401 Unauthorized');
    echo "<html><body>That area is accessible for members only</body></html>\n";
} else {
	$user[0] = $user[0] ^ ' ';
	$image = file_get_contents("../img/42.png");
	$enc = base64_encode($image);
    echo "<html><body>\nHello {$user}<br />\n";
    echo "<img src='data:image/png;base64,{$enc}'>";
    echo "\n</body></html>\n";
}
