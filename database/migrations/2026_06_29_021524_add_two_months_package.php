<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The join.blade.php marketing grid advertises a "2 Month Access" package
     * at $149.99 that never existed as a row in packages — added here so the
     * cashier checkout has a real package to charge against.
     *
     * @return void
     */
    public function up()
    {
        DB::table('packages')->insertOrIgnore([
            'name' => '2 Months',
            'slug' => '2-months',
            'description' => '2 months of access to INSPIN picks and analysis.',
            'price' => 149.99,
            'duration' => '2 Months',
            'duration_days' => 60,
            'features' => json_encode(['All Sport Picks', 'Simulation Model Access', 'Daily Consensus Data', 'Betting Trends', '24/7 Support']),
            'is_active' => 1,
            'sort_order' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('packages')->where('slug', '2-months')->delete();
    }
};
