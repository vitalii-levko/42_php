#!/usr/bin/php
<?php
function ft_split($s)
{
    $ret = array();
    if ($s) {
        $s = preg_replace('!\s+!', ' ', trim($s));
        $ret = explode(" ", $s);
        sort($ret);
        return $ret;
    }
    return $ret;
}

for ($i = 1; $i < $argc; $i++) {
    $s = preg_replace('!\s+!', ' ', trim($argv[$i]));
    $curr = ft_split($s);
    if (!isset($res))
        $res = array_merge($curr);
    else
        $res = array_merge($res, $curr);
}
if (isset($res)) {
    sort($res);
    foreach ($res as $item)
        echo "$item\n";
}
?>
