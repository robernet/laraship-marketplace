<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('plan_usage', function (Blueprint $table) {
    $table->nullableMorphs('model');
    $table->boolean('ignored')->default(false);
});
