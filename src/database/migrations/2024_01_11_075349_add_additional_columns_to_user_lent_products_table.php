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
        Schema::table('user_lent_products', function (Blueprint $table) {
            $table->dateTime('accepted_at');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('total_product_amount', 10, 2);
            $table->decimal('total_commission_amount', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_lent_products', function (Blueprint $table) {
            $table->dropColumn('accepted_at');
            $table->dropColumn('total_amount');
            $table->dropColumn('total_product_amount');
            $table->dropColumn('total_commission_amount');
        });
    }
};
