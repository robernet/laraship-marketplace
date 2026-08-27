<?php


\Corals\Settings\Models\Setting::where('code', ['days_of_the_week'])
    ->update(['code' => 'utility_days_of_the_week', 'category' => 'Utilities']);
