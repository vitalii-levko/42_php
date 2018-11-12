#!/usr/bin/php
<?php
if ($argc == 4) {
    $nb1 = (int)trim($argv[1]);
    $op = trim($argv[2]);
    $nb2 = (int)trim($argv[3]);
    switch ($op):
        case "+":
            echo $nb1 + $nb2;
            break;
        case "-":
            echo $nb1 - $nb2;
            break;
        case "*":
            echo $nb1 * $nb2;
            break;
        case "/":
            echo $nb1 / $nb2;
            break;
        case "%":
            echo $nb1 % $nb2;
            break;
    endswitch;
    echo "\n";
} else
    echo "Incorrect Parameters\n";
?>
