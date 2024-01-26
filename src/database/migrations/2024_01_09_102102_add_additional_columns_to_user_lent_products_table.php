<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     */
    public function up(): void
    {
        Schema::table('user_lent_products', function (Blueprint $table) {
            $table->unsignedInteger('delivery_preference')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_mobile')->nullable();
            $table->string('contact_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_lent_products', function (Blueprint $table) {
            $table->dropColumn('delivery_preference');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('address');
            $table->dropColumn('zip');
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_mobile');
            $table->dropColumn('contact_email');
        });
    }
};
