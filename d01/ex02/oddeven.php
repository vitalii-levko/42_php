#!/usr/bin/php
<?php
echo "Enter a number: ";
while (($num = fgets(STDIN)) !== false) {
    $num = trim($num);
    if (is_numeric($num))
        echo ($num % 2) ? "The number $num is odd\n" : "The number $num is even\n";
    else
        echo "'$num' is not a number\n";
    echo "Enter a number: ";
}
echo "\n";
?>
