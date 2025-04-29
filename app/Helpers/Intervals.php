<?php

namespace App\Helpers;

class Intervals {
    public static function wordsToMinutes($word){
        switch ($word) {
            case '30mins':
                $step = 30 * 60; // 30 minutes
                break;
            case '1hr':
                $step = 60 * 60; // 1 hour
                break;
            case '90mins':
                $step = 90 * 60; // 90 minutes
                break;
            case '2hrs':
                $step = 2 * 60 * 60; // 2 hours
                break;
            case 'halfday':
                $step = 4 * 60 * 60; // 4 hours (assuming half-day is 4 hours)
                break;
            case 'fullday':
                $step = 8 * 60 * 60; // 8 hours (assuming full-day is 8 hours)
                break;
            default:
                throw new \Exception('Invalid interval specified');
        }

        return $step;
    }
}
