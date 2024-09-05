<?php

namespace App\Helpers;

class Date
{
    public static function formatToDayAndMonth($date)
    {
        // Create a DateTime object
        $dateTime = new \DateTime($date);

        // Extract the day and add the ordinal suffix
        $day = $dateTime->format('j'); // Day without leading zeros
        $dayWithSuffix = self::getOrdinalSuffix($day);

        // Format the month
        $month = $dateTime->format('M'); // Short month name (e.g., 'Sep')

        // Combine them into the desired format
        return "{$dayWithSuffix} {$month}";
    }

    // Private helper method to get the ordinal suffix
    private static function getOrdinalSuffix($day)
    {
        if (!in_array(($day % 100), [11, 12, 13])) {
            switch ($day % 10) {
                case 1:
                    return $day . 'st';
                case 2:
                    return $day . 'nd';
                case 3:
                    return $day . 'rd';
            }
        }
        return $day . 'th';
    }
}
?>
