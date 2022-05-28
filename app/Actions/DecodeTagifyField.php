<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class DecodeTagifyField
{
    use AsAction;

    /**
     * Processes a tagify field into an array of
     * objects or a single object.
     * 
     * @param array|string $raw
     * @return array|object
     */
    public function handle($raw)
    {
        try
        {
            if(is_array($raw) && count($raw) > 0) 
            {
                for($i = 0; $i < count($raw); $i++) {
                    $processed[] = json_decode($raw[$i])[0];
                }
            }
            else 
            {
                $processed = json_decode($raw)[0];
            }
        }
        catch (\Exception $e) {}

        return isset($processed) ? $processed : null;
    }
}
