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
            $table->enum('status', ['Pending', 'Succeeded'])
                  ->after('accepted');  // Place it after an existing column
                 
            // Drop the old column if needed
            $table->dropColumn('accepted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('accepted')->after('status');
            $table->dropColumn('status');
        });
    }
};
