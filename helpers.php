<?php

if (! function_exists('removeNewLineInTheEnd')) {
    function removeNewLineInTheEnd(string $str) {
        $len = strlen($str);
        if ((strripos($str, "\n") === $len - 1) || (strripos($str, "\r") === $len - 1)) {
            $str = substr($str, 0, $len - 1);
            return removeNewLineInTheEnd($str);
        } else {
            return $str;
        }
    }
}