#!/usr/bin/php
<?php
function ft_error($e)
{
    echo "$e\n";
}

if ($argc > 1) {
    $filename = $argv[1];
    if (!file_exists($filename)) {
        ft_error("No such file or directory");
        return;
    }
    if (!($content = @file_get_contents($filename))) {
        ft_error("Failed to read the file");
        return;
    }
    if (($content = preg_replace_callback("/(\<a.*\>)(.+?)(\<)/im", function ($matches) {
            $matches[2] = strtoupper($matches[2]);
            $s = implode(array_slice($matches, 1));
            return $s;
        }, $content)) !== false) {
        if (($content = preg_replace_callback("/(\<a.*title=\")(.+?)(\".*\>)/im", function ($matches) {
                $matches[2] = strtoupper($matches[2]);
                $s = implode("", array_slice($matches, 1));
                return $s;
            }, $content)) !== false) {
            echo $content;
        }
    }
}
?>