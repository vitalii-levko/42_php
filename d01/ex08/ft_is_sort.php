#!/usr/bin/php
<?php
function ft_is_sort($arr)
{
    if (isset($arr)) {
        $len = sizeof($arr);
        if ($len <= 2)
            return true;
        if ($arr[0] < $arr[1])
            for ($i = 2; $i < $len; $i++) {
                if ($arr[$i] < $arr[$i - 1])
                    return false;
            }
        else
            for ($i = 2; $i < $len; $i++) {
                if ($arr[$i] > $arr[$i - 1])
                    return false;
            }
        return true;
    }
    return false;
}

?>
