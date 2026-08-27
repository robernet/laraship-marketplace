<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('plan_usage', function (Blueprint $table) {
    $table->double('used_value')->default(1.0);
});
