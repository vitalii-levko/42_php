#!/usr/bin/php
<?php
function ft_error()
{
    echo "Wrong Format\n";
}

function en_week($w)
{
    switch ($w) {
        case "lundi":
        case "Lundi":
            return "Monday";
            break;
        case "mardi":
        case "Mardi":
            return "Tuesday";
            break;
        case "mercredi":
        case "Mercredi":
            return "Wednesday";
            break;
        case "jeudi":
        case "Jeudi":
            return "Thursday";
            break;
        case "vendredi":
        case "Vendredi":
            return "Friday";
            break;
        case "samedi":
        case "Samedi":
            return "Saturday";
            break;
        case "dimanche":
        case "Dimanche":
            return "Sunday";
            break;
    }
    return NULL;
}

function en_month($m)
{
    switch ($m) {
        case "janvier":
        case "Janvier":
            return "January";
            break;
        case "février":
        case "Février":
            return "February";
            break;
        case "mars":
        case "Mars":
            return "March";
            break;
        case "avril":
        case "Avril":
            return "April";
            break;
        case "mai":
        case "Mai":
            return "May";
            break;
        case "juin":
        case "Juin":
            return "June";
            break;
        case "juillet":
        case "Juillet":
            return "July";
            break;
        case "aout":
        case "Aout":
            return "August";
            break;
        case "septembre":
        case "Septembre":
            return "September";
            break;
        case "octobre":
        case "Octobre":
            return "October";
            break;
        case "novembre":
        case "Novembre":
            return "November";
            break;
        case "décembre":
        case "Décembre":
            return "December";
            break;
    }
    return NULL;
}

date_default_timezone_set("Europe/Paris");
if ($argc > 1) {
    if (preg_match("/(^[a-zA-ZàâäôéèëêïîçùûüÿæœÀÂÄÔÉÈËÊÏÎŸÇÙÛÜÆŒ]{1}[a-zàâäôéèëêïîçùûüÿæœ]{4,7}) (\d{1,2}) ([a-zA-ZàâäôéèëêïîçùûüÿæœÀÂÄÔÉÈËÊÏÎŸÇÙÛÜÆŒ]{1}[a-zàâäôéèëêïîçùûüÿæœ]{2,8}) (\d{4}) (\d{2}:\d{2}:\d{2})$/", $argv[1], $matches) !== false) {
        $matches[1] = en_week($matches[1]);
        $matches[3] = en_month($matches[3]);
        if (!$matches[1] || !$matches[2]) {
            ft_error();
            return;
        }
        $s = implode(" ", array_slice($matches, 2));
        $r = strtotime($s) . "\n";
        echo "$r";
    } else
        ft_error();
}
?>