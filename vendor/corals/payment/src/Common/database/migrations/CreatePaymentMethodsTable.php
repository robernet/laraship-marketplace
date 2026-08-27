<?php

namespace Corals\Modules\Payment\Common\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_payment_methods', function (Blueprint $table) {
            $table->increments('id');

            $table->morphs('parent');

            $table->string('holder_name')->nullable();
            $table->string('holder_email')->nullable();
            $table->string('expiry_month')->nullable();
            $table->string('expiry_year')->nullable();
            $table->string('type')->default('card');
            $table->string('brand')->nullable();
            $table->string('last_four')->nullable();

            $table->boolean('is_default')->default(false);

            $table->text('properties')->nullable();
            $table->text('gateway')->nullable();
            $table->string('reference_id')->nullable();

            $table->enum('status', ['active', 'invalid', 'expired'])->default('active')->index();
            $table->text('notes')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_payment_methods');
    }
}
