<?php 

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

if (!function_exists('format_date_input')) {
    function format_date_input($date)
    {
        return $date ? \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d') : '';
    }
}

if (!function_exists('format_date')) {
    function format_date($date)
    {
        return Carbon::parse($date)->format('d-m-Y');
    }
}

if (!function_exists('format_date_other')) {
    function format_date_other($date)
    {
        return Carbon::parse($date)->format('d-m-Y h:i:s A'); // 12-hour format with AM/PM
    }
}


if (!function_exists('activeMenu')) {
    function activeMenu($pattern, $class = 'active') {
        return Request::is($pattern) ? $class : '';
    }
}

if (!function_exists('activeParent')) {
    function activeParent(array $patterns, $class = 'active') {
        foreach ($patterns as $pattern) {
            if (Request::is($pattern)) {
                return $class;
            }
        }
        return '';
    }
}

function calculateDaysDifference($givenDate)
{
    // Create DateTime objects for the given date and current date
    $now = new DateTime(); // current date
    $date = new DateTime($givenDate); // given date
    
    // Calculate the difference
    $interval = $now->diff($date);
    
    // Return the number of days
    return $interval->days;
}


?>