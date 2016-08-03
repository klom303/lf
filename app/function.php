<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/23
 * Time: 17:43
 */

function startsWith($haystack, $needles)
{
    foreach ((array)$needles as $needle) {
        if ($needle != '' && strpos($haystack, $needle) === 0) {
            return true;
        }
    }

    return false;
}

function snake($value, $delimiter = '_')
{
    if (!ctype_lower($value)) {
        $value = preg_replace('/\s+/', '', $value);

        $value = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1' . $delimiter, $value));
    }

    return $value;
}