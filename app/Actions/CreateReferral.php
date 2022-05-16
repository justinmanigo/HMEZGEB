<?php

namespace App\Actions;

use App\Models\Referral;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateReferral
{
    use AsAction;

    public function handle($validated, $type)
    {
        return Referral::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $type,
        ]);
    }
}
