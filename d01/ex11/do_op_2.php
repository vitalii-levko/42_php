#!/usr/bin/php
<?php
function ft_error()
{
    echo "Syntax Error\n";
}

if ($argc == 2) {
    $s = preg_replace('!\s+!', ' ', trim($argv[1]));
    if (preg_match("/(^\d+)(?:\s*)([\+\-\*\/\%])(?:\s*)(\d+$)/", $s, $matches) !== false) {
        if (sizeof($matches) == 4) {
            if (is_numeric($matches[1]) && is_numeric($matches[3])) {
                $nb1 = (int)$matches[1];
                $op = $matches[2];
                $nb2 = (int)$matches[3];
                switch ($op):
                    case "+":
                        echo $nb1 + $nb2 . "\n";
                        break;
                    case "-":
                        echo $nb1 - $nb2 . "\n";
                        break;
                    case "*":
                        echo $nb1 * $nb2 . "\n";
                        break;
                    case "/":
                        echo $nb1 / $nb2 . "\n";
                        break;
                    case "%":
                        echo $nb1 % $nb2 . "\n";
                        break;
                    default:
                        ft_error();
                endswitch;
            } else
                ft_error();
        } else
            ft_error();
    } else
        ft_error();
} else
    echo "Incorrect Parameters\n";
?>
