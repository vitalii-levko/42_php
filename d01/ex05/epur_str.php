#!/usr/bin/php
<?php
if ($argc == 2) {
    $s = preg_replace('!\s+!', ' ', trim($argv[1]));
    echo "$s\n";
}
?>
