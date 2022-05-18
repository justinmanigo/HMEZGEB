<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Andegna\DateTimeFactory;

class ConvertEthiopianToGregorian
{
    use AsAction;

    /**
     * This function converts a Ethiopian Date to Gregorian.
     * 
     * This was done by collecting the raw values of a Ethiopian Date
     * such as the mandatory values $year, $month, $day, and optional
     * values $hour, $min, $sec. These values are used to generate
     * a timestamp of such Ethiopian Date using Andegna\DateTimeFactory.
     * 
     * In case the ethiopian date is not provided in the arguments,
     * it will generate instead the timestamp of the present time.
     * 
     * This function shall return the Gregorian Date with instance
     * \Andegna\DateTimeFactory. Assuming the resulting variable is
     * $var, you may call the following to print or store the timestamp
     * value to the database.
     *   $var->format('Y-m-d h:i:s'); // Date and Time
     *   $var->format('Y-m-d');       // Date
     * 
     * @param string $ethiopian_date = null
     * @return \Andegna\DateTimeFactory
     */
    public function handle(
        $year = null, 
        $month = null, 
        $day = null, 
        $hour = null, 
        $min = null, 
        $sec = null)
    {
        if(!$year && !$month && !$day && !$hour && !$min && !$sec) 
            $ethiopian_date = DateTimeFactory::now(); 
        else if($year && $month && $day && !$hour && !$min && !$sec)
            $ethiopian_date = DateTimeFactory::of($year, $month, $day);
        else if($year && $month && $day && $hour && $min && $sec) 
            $ethiopian_date = DateTimeFactory::of($year, $month, $day, $hour, $min, $sec);

        return $ethiopian_date->toGregorian();
    }
}
