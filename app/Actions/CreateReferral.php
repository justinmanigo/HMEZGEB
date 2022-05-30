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
            'name' => isset($validated['name']) ? $validated['name'] : null,
            'email' => isset($validated['email']) ? $validated['email'] : null,
            'type' => $type,
            'trial_duration' => $type == 'normal' ? 1 : $validated['trial_duration'],
            'trial_duration_type' => $type == 'normal' ? 'week' : $validated['trial_duration_type'],
        ]);
    }
}
