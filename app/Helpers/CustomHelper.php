<?php

function formatDate($dateTime)
{
    $splitTimeStamp = explode("-", explode(' ',$dateTime)[0]);
    $year = $splitTimeStamp[0];
    $month = $splitTimeStamp[1];
    $day = $splitTimeStamp[2];
    if ($month == 1) {
        $month = 'იან';
    } elseif ($month == 2) {
        $month = 'თებ';
    } elseif ($month == 3) {
        $month = 'მარ';
    } elseif ($month == 4) {
        $month = 'აპრ';
    } elseif ($month == 5) {
        $month = 'მაი';
    } elseif ($month == 6) {
        $month = 'ინვ';
    } elseif ($month == 7) {
        $month = 'ივლ';
    } elseif ($month == 8) {
        $month = 'აგვ';
    } elseif ($month == 9) {
        $month = 'სექ';
    } elseif ($month == 10) {
        $month = 'ოქტ';
    } elseif ($month == 11) {
        $month = 'ნოე';
    } elseif ($month == 12) {
        $month = 'დეკ';
    }
    return $day . ' ' . $month . ' ' . $year;
}


if (!function_exists('array_sort_recursive')) {
    /**
     * Recursively sort an array by keys and values.
     *
     * @param array $array
     * @return array
     */
    function array_sort_recursive($array)
    {
        return Arr::sortRecursive($array);
    }
}
