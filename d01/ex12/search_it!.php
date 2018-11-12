#!/usr/bin/php
<?php
if ($argc > 2) {
    $key = $argv[1];
    for ($i = 2; $i < $argc; $i++) {
        if (preg_match("/(^[^:]+)([:])([^:]+$)/", $argv[$i], $matches) !== false) {
            if (sizeof($matches) == 4) {
                if ($matches[1] == $key)
                    $res = $matches[3];
            } else
                return;
        } else
            return;
    }
    if (isset($res))
        echo "$res\n";
}
?>