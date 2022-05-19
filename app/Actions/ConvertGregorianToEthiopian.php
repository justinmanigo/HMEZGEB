<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Carbon\Carbon;
use Andegna\DateTimeFactory;

class ConvertGregorianToEthiopian
{
    use AsAction;

    /**
     * This function converts a Gregorian timestamp string 
     * from database with format 'Y-m-d h:i:s' to a Ethiopian date.
     * 
     * This was done by first parsing the Gregorian timestamp
     * string using \Carbon\Carbon, then extract the raw Gregorian 
     * timestamp value for conversion on Andegna\DateTimeFactory.
     * 
     * In case the Gregorian timestamp is not provided in the argument, 
     * it will generate instead the timestamp of the present time.
     * 
     * This function shall return the Ethiopian Date with instance
     * \Andegna\DateTimeFactory. Assuming the resulting variable is 
     * $var, you may call the following to print or store the timestamp
     * value to the database.
     *   $var->format('Y-m-d h:i:s'); // Date and Time
     *   $var->format('Y-m-d');       // Date
     * 
     * @param string $gregorian_date = null
     * @return \Andegna\DateTimeFactory
     */
    public function handle($gregorian_date = null)
    {
        if(!$gregorian_date) $gregorian_date = Carbon::now();
        else $gregorian_date = Carbon::parse($gregorian_date);

        return DateTimeFactory::fromTimestamp($gregorian_date->timestamp);
    }
}
