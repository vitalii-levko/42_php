#!/usr/bin/php
<?php
function ft_split($s)
{
    $ret = array();
    if ($s) {
        $s = preg_replace('!\s+!', ' ', trim($s));
        $ret = explode(" ", $s);
        return $ret;
    }
    return $ret;
}

if ($argc > 1) {
    $s = preg_replace('!\s+!', ' ', trim($argv[1]));
    $res = ft_split($s);
    $len = sizeof($res);
    for ($i = 1; $i < $len; $i++)
        echo "$res[$i] ";
    echo "$res[0]\n";
}
?>
