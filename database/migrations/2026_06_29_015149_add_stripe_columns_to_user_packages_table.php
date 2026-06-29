<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_packages', function (Blueprint $table) {
            $table->string('stripe_checkout_session_id')->nullable()->index();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->decimal('amount_paid', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_packages', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_checkout_session_id',
                'stripe_customer_id',
                'stripe_payment_intent_id',
                'amount_paid',
            ]);
        });
    }
};
