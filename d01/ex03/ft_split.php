#!/usr/bin/php
<?php
function ft_split($s)
{
    $ret = array();
    if (isset($s)) {
        $s = preg_replace('!\s+!', ' ', trim($s));
        $ret = explode(" ", $s);
        sort($ret);
    }
    return $ret;
}

?>
