<?php

namespace App\Http\Traits;

use Kaiopiola\Keygen\Key;

/**
 * Credits to James Mills
 * https://github.com/jamesmills/eloquent-uuid/blob/master/src/HasUuidTrait.php
 */
trait HasReferralCode
{
    protected static function bootHasReferralCode()
    {
        static::creating(function ($model) {

            if (!$model->code) {
                $exampleKey = new Key;
                $exampleKey->setPattern("XXXXX-XXXXX-XXXXX");
                $model->code = (string)$exampleKey->generate();
            }
        });
    }
}