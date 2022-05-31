<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class GenerateAccountingPeriods
{
    use AsAction;

    private $accounting_periods_template = [
        [
            'period_number' => 1,
            // Gregorian Common
            'month_from' => 1,
            'day_from' => 1,
            'month_to' => 1,
            'day_to' => 31,
            // Gregorian Leap
            'month_from_leap' => 1,
            'day_from_leap' => 1,
            'month_to_leap' => 1,
            'day_to_leap' => 31,
            // Ethiopian Common
            'month_from_ethiopian' => 7,
            'month_to_ethiopian' => 8,
            'day_from_ethiopian' => 8,
            'day_to_ethiopian' => 6,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 7,
            'month_to_ethiopian_leap' => 8,
            'day_from_ethiopian_leap' => 8,
            'day_to_ethiopian_leap' => 6,
        ],
        [
            'period_number' => 2,
            // Gregorian Common
            'month_from' => 2,
            'day_from' => 1,
            'month_to' => 2,
            'day_to' => 28,
            // Gregorian Leap
            'month_from_leap' => 2,
            'day_from_leap' => 1,
            'month_to_leap' => 2,
            'day_to_leap' => 29,
            // Ethiopian Common
            'month_from_ethiopian' => 8,
            'day_from_ethiopian' => 7,
            'month_to_ethiopian' => 9,
            'day_to_ethiopian' => 10,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 8,
            'day_from_ethiopian_leap' => 7,
            'month_to_ethiopian_leap' => 9,
            'day_to_ethiopian_leap' => 11,
        ],
        [
            'period_number' => 3,
            // Gregorian Common
            'month_from' => 3,
            'day_from' => 1,
            'month_to' => 3,
            'day_to' => 31,
            // Gregorian Leap
            'month_from_leap' => 3,
            'day_from_leap' => 1,
            'month_to_leap' => 3,
            'day_to_leap' => 31,
            // Ethiopian Common
            'month_from_ethiopian' => 9,
            'day_from_ethiopian' => 11,
            'month_to_ethiopian' => 10,
            'day_to_ethiopian' => 10,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 9,
            'day_from_ethiopian_leap' => 12,
            'month_to_ethiopian_leap' => 10,
            'day_to_ethiopian_leap' => 11,
        ],
        [
            'period_number' => 4,
            // Gregorian Common
            'month_from' => 4,
            'day_from' => 1,
            'month_to' => 4,
            'day_to' => 30,
            // Gregorian Leap
            'month_from_leap' => 4,
            'day_from_leap' => 1,
            'month_to_leap' => 4,
            'day_to_leap' => 30,
            // Ethiopian Common
            'month_from_ethiopian' => 10,
            'day_from_ethiopian' => 11,
            'month_to_ethiopian' => 11,
            'day_to_ethiopian' => 9,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 10,
            'day_from_ethiopian_leap' => 12,
            'month_to_ethiopian_leap' => 11,
            'day_to_ethiopian_leap' => 10,
        ],
        [
            'period_number' => 5,
            // Gregorian Common
            'month_from' => 5,
            'day_from' => 1,
            'month_to' => 5,
            'day_to' => 31,
            // Gregorian Leap
            'month_from_leap' => 5,
            'day_from_leap' => 1,
            'month_to_leap' => 5,
            'day_to_leap' => 31,
            // Ethiopian Common
            'month_from_ethiopian' => 11,
            'day_from_ethiopian' => 10,
            'month_to_ethiopian' => 12,
            'day_to_ethiopian' => 9,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 11,
            'day_from_ethiopian_leap' => 11,
            'month_to_ethiopian_leap' => 12,
            'day_to_ethiopian_leap' => 10,
        ],
        [
            'period_number' => 6,
            // Gregorian Common
            'month_from' => 6,
            'day_from' => 1,
            'month_to' => 6,
            'day_to' => 30,
            // Gregorian Leap
            'month_from_leap' => 6,
            'day_from_leap' => 1,
            'month_to_leap' => 6,
            'day_to_leap' => 30,
            // Ethiopian Common
            'month_from_ethiopian' => 12,
            'day_from_ethiopian' => 10,
            'month_to_ethiopian' => 1,
            'day_to_ethiopian' => 8,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 12,
            'day_from_ethiopian_leap' => 11,
            'month_to_ethiopian_leap' => 1,
            'day_to_ethiopian_leap' => 9,
        ],
        [
            'period_number' => 7,
            // Gregorian Common
            'month_from' => 7,
            'day_from' => 1,
            'month_to' => 7,
            'day_to' => 31,
            // Gregorian Leap
            'month_from_leap' => 7,
            'day_from_leap' => 1,
            'month_to_leap' => 7,
            'day_to_leap' => 31,
            // Ethiopian Common
            'month_from_ethiopian' => 1,
            'day_from_ethiopian' => 9,
            'month_to_ethiopian' => 2,
            'day_to_ethiopian' => 7,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 1,
            'day_from_ethiopian_leap' => 10,
            'month_to_ethiopian_leap' => 2,
            'day_to_ethiopian_leap' => 8,
        ],
        [
            'period_number' => 8,
            // Gregorian Common
            'month_from' => 8,
            'day_from' => 1,
            'month_to' => 8,
            'day_to' => 31,
            // Gregorian Leap
            'month_from_leap' => 8,
            'day_from_leap' => 1,
            'month_to_leap' => 8,
            'day_to_leap' => 31,
            // Ethiopian Common
            'month_from_ethiopian' => 2,
            'day_from_ethiopian' => 8,
            'month_to_ethiopian' => 3,
            'day_to_ethiopian' => 9,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 2,
            'day_from_ethiopian_leap' => 9,
            'month_to_ethiopian_leap' => 3,
            'day_to_ethiopian_leap' => 9,
        ],
        [
            'period_number' => 9,
            // Gregorian Common
            'month_from' => 9,
            'day_from' => 1,
            'month_to' => 9,
            'day_to' => 30,
            // Gregorian Leap
            'month_from_leap' => 9,
            'day_from_leap' => 1,
            'month_to_leap' => 9,
            'day_to_leap' => 30,
            // Ethiopian Common
            'month_from_ethiopian' => 3,
            'day_from_ethiopian' => 10,
            'month_to_ethiopian' => 4,
            'day_to_ethiopian' => 8,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 3,
            'day_from_ethiopian_leap' => 10,
            'month_to_ethiopian_leap' => 4,
            'day_to_ethiopian_leap' => 8,
        ],
        [
            'period_number' => 10,
            // Gregorian Common
            'month_from' => 10,
            'day_from' => 1,
            'month_to' => 10,
            'day_to' => 31,
            // Gregorian Leap
            'month_from_leap' => 10,
            'day_from_leap' => 1,
            'month_to_leap' => 10,
            'day_to_leap' => 31,
            // Ethiopian Common
            'month_from_ethiopian' => 4,
            'day_from_ethiopian' => 9,
            'month_to_ethiopian' => 5,
            'day_to_ethiopian' => 8,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 4,
            'day_from_ethiopian_leap' => 9,
            'month_to_ethiopian_leap' => 5,
            'day_to_ethiopian_leap' => 8,
        ],
        [
            'period_number' => 11,
            // Gregorian Common
            'month_from' => 11,
            'day_from' => 1,
            'month_to' => 11,
            'day_to' => 30,
            // Gregorian Leap
            'month_from_leap' => 11,
            'day_from_leap' => 1,
            'month_to_leap' => 11,
            'day_to_leap' => 30,
            // Ethiopian Common
            'month_from_ethiopian' => 5,
            'day_from_ethiopian' => 9,
            'month_to_ethiopian' => 6,
            'day_to_ethiopian' => 7,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 5,
            'day_from_ethiopian_leap' => 9,
            'month_to_ethiopian_leap' => 6,
            'day_to_ethiopian_leap' => 7,
        ],
        [
            'period_number' => 12,
            // Gregorian Common
            'month_from' => 12,
            'day_from' => 1,
            'month_to' => 12,
            'day_to' => 31,
            // Gregorian Leap
            'month_from_leap' => 12,
            'day_from_leap' => 1,
            'month_to_leap' => 12,
            'day_to_leap' => 31,
            // Ethiopian Common
            'month_from_ethiopian' => 6,
            'day_from_ethiopian' => 8,
            'month_to_ethiopian' => 7,
            'day_to_ethiopian' => 7,
            // Ethiopian Leap
            'month_from_ethiopian_leap' => 6,
            'day_from_ethiopian_leap' => 8,
            'month_to_ethiopian_leap' => 7,
            'day_to_ethiopian_leap' => 7,
        ],
    ];

    public function handle($accounting_system_id, $calendar_type, $year, $accounting_system_user_id)
    {
        $isLeapYear = $this->isLeapYear($calendar_type, $year);
        $periods = [];

        if($isLeapYear && $calendar_type == 'gregorian') {
            $periods = $this->generateGregorianLeapYearPeriods($accounting_system_id, $year, $accounting_system_user_id);
        }
        else if($isLeapYear && $calendar_type == 'ethiopian') {
            $periods = $this->generateEthiopianLeapYearPeriods($accounting_system_id, $year, $accounting_system_user_id);
        }
        else if(!$isLeapYear && $calendar_type == 'gregorian') {
            $periods = $this->generateGregorianCommonYearPeriods($accounting_system_id, $year, $accounting_system_user_id);
        }
        else if(!$isLeapYear && $calendar_type == 'ethiopian') {
            $periods = $this->generateEthiopianCommonYearPeriods($accounting_system_id, $year, $accounting_system_user_id);
        }

        DB::table('accounting_periods')->insert($periods);
    }

    private function isLeapYear($calendar_type, $year)
    {
        if ($calendar_type == 'ethiopian') {
            $year += 8;  
        } 

        return $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
    }

    private function generateGregorianLeapYearPeriods($accounting_system_id, $year, $accounting_system_user_id)
    {
        $periods = [];

        for($i = 0; $i < count($this->accounting_periods_template); $i++)
        {
            $periods[] = [
                'accounting_system_id' => $accounting_system_id,
                'accounting_system_user_id' => $accounting_system_user_id,
                'period_number' => $this->accounting_periods_template[$i]['period_number'],
                'date_from' => "{$year}-{$this->accounting_periods_template[$i]['month_from_leap']}-{$this->accounting_periods_template[$i]['day_from_leap']}",
                'date_to' => "{$year}-{$this->accounting_periods_template[$i]['month_to_leap']}-{$this->accounting_periods_template[$i]['day_to_leap']}",
                'created_at' => now(),
                'updated_at' => now(),
            ]; 
        }

        return $periods;
    }

    private function generateGregorianCommonYearPeriods($accounting_system_id, $year, $accounting_system_user_id)
    {
        $periods = [];

        for($i = 0; $i < count($this->accounting_periods_template); $i++)
        {
            $periods[] = [
                'accounting_system_id' => $accounting_system_id,
                'accounting_system_user_id' => $accounting_system_user_id,
                'period_number' => $this->accounting_periods_template[$i]['period_number'],
                'date_from' => "{$year}-{$this->accounting_periods_template[$i]['month_from']}-{$this->accounting_periods_template[$i]['day_from']}",
                'date_to' => "{$year}-{$this->accounting_periods_template[$i]['month_to']}-{$this->accounting_periods_template[$i]['day_to']}",
                'created_at' => now(),
                'updated_at' => now(),
            ]; 
        }

        return $periods;
    }

    private function generateEthiopianLeapYearPeriods($accounting_system_id, $year, $accounting_system_user_id)
    {
        $periods = [];
        $year += 7;

        for($i = 0; $i < count($this->accounting_periods_template); $i++)
        {
            $periods[] = [
                'accounting_system_id' => $accounting_system_id,
                'accounting_system_user_id' => $accounting_system_user_id,
                'period_number' => $this->accounting_periods_template[$i]['period_number'],
                'date_from' => "{$year}-{$this->accounting_periods_template[$i]['month_from_ethiopian_leap']}-{$this->accounting_periods_template[$i]['day_from_ethiopian_leap']}",
                'date_to' => ($i == 5 ? ++$year : $year) + "-{$this->accounting_periods_template[$i]['month_to_ethiopian_leap']}-{$this->accounting_periods_template[$i]['day_to_ethiopian_leap']}",
                'created_at' => now(),
                'updated_at' => now(),
            ]; 
        }

        return $periods;
    }

    private function generateEthiopianCommonYearPeriods($accounting_system_id, $year, $accounting_system_user_id)
    {
        $periods = [];
        $year += 7;

        for($i = 0; $i < count($this->accounting_periods_template); $i++)
        {
            $periods[] = [
                'accounting_system_id' => $accounting_system_id,
                'accounting_system_user_id' => $accounting_system_user_id,
                'period_number' => $this->accounting_periods_template[$i]['period_number'],
                'date_from' => "{$year}-{$this->accounting_periods_template[$i]['month_from_ethiopian']}-{$this->accounting_periods_template[$i]['day_from_ethiopian']}",
                'date_to' => ($i == 5 ? ++$year : $year) . "-{$this->accounting_periods_template[$i]['month_to_ethiopian']}-{$this->accounting_periods_template[$i]['day_to_ethiopian']}",
                'created_at' => now(),
                'updated_at' => now(),
            ]; 
        }

        return $periods;
    }


}
