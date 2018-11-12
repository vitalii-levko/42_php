#!/usr/bin/php
<?php
function ft_split($s)
{
    $ret = array();
    if (isset($s)) {
        $s = preg_replace('!\s+!', ' ', trim($s));
        $ret = explode(" ", $s);
        return $ret;
    }
    return $ret;
}

function ft_is_alpha($c)
{
    if (("a" <= $c && $c <= "z") || ("A" <= $c && $c <= "Z"))
        return true;
    return false;
}

function ft_tolower($c)
{
    if ('a' <= $c && $c <= 'z')
        return $c;
    return ($c ^ ' ');
}

function ft_custom_sort($a, $b)
{
    $i = 0;
    $l = min(strlen($a), strlen($b));
    while ($i < $l) {
        if ($a[$i] != $b[$i]) {
            if (is_numeric($a[$i]) && ft_is_alpha($b[$i]))
                return 1;
            elseif (!is_numeric($a[$i]) && !ft_is_alpha($a[$i]) && (is_numeric($b[$i]) || ft_is_alpha($b[$i])))
                return 1;
            elseif (is_numeric($a[$i]) && !is_numeric($b[$i]) && !ft_is_alpha($b[$i]))
                return -1;
            elseif (ft_is_alpha($a[$i]) && !ft_is_alpha($b[$i]))
                return -1;
            elseif (ft_is_alpha($a[$i]) && ft_is_alpha($b[$i])) {
                if (ft_tolower($a[$i]) != ft_tolower($b[$i]))
                    return (ft_tolower($a[$i]) < ft_tolower($b[$i])) ? -1 : 1;
                else
                    return 0;
            } elseif (is_numeric($a[$i]) && is_numeric($b[$i]))
                return ($a[$i] < $b[$i]) ? -1 : 1;
            else
                return ($a[$i] < $b[$i]) ? -1 : 1;
        }
        $i++;
    }
    if ($a[$i])
        return 1;
    if ($b[$i])
        return -1;
    return 0;
}

for ($i = 1; $i < $argc; $i++) {
    $s = preg_replace('!\s+!', ' ', trim($argv[$i]));
    $curr = ft_split($s);
    if (isset($res))
        $res = array_merge($res, $curr);
    else
        $res = array_merge($curr);
}
if (isset($res)) {
    sort($res);
    foreach ($res as $item) {
        if (is_numeric($item))
            $num[] = $item;
        elseif (ft_is_alpha($item[0]))
            $str[] = $item;
        else
            $sym[] = $item;
    }
    if (isset($str)) {
        usort($str, 'ft_custom_sort');
        foreach ($str as $item) {
            echo "$item\n";
        }
    }
    if (isset($num)) {
        usort($num, 'ft_custom_sort');
        foreach ($num as $item) {
            echo "$item\n";
        }
    }
    if (isset($sym)) {
        foreach ($sym as $item) {
            echo "$item\n";
        }
        usort($sym, 'ft_custom_sort');
    }
}
?>
