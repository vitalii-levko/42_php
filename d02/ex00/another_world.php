#!/usr/bin/php
<?php
if ($argc > 1) {
    $s = preg_replace('!\s+!', ' ', trim($argv[1]));
    echo "$s\n";
}
?>
