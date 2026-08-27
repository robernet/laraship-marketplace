<?php

namespace Corals\Modules\Foo\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FooTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foo_bars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $this->commonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foo_bars');
    }

    protected function commonColumns(Blueprint $table)
    {
        $table->text('properties')->nullable();
        $table->auditable();
        $table->softDeletes();
        $table->timestamps();
    }
}
