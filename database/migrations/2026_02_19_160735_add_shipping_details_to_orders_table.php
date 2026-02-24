<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_address')->nullable()->after('status');
            $table->string('shipping_city')->nullable()->after('shipping_address');
            $table->string('shipping_state')->nullable()->after('shipping_city');
            $table->string('shipping_zip_code')->nullable()->after('shipping_state');
            $table->string('shipping_country')->nullable()->after('shipping_zip_code');
            $table->string('tracking_number')->nullable()->after('shipping_country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_address',
                'shipping_city',
                'shipping_state',
                'shipping_zip_code',
                'shipping_country',
                'tracking_number',
            ]);
        });
    }
};
