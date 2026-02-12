<?php

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

if (!function_exists('log_activity')) {
    function log_activity(string $event, $subject, array $properties = []): void
    {
        if (!$subject) {
            return; // subject yoksa log basma
        }

        Activity::create([
            'user_id'      => Auth::id(),
            'subject_type' => get_class($subject),
            'subject_id'   => $subject->id,
            'event'        => $event,
            'properties'   => $properties ?: null,
        ]);
    }
}
