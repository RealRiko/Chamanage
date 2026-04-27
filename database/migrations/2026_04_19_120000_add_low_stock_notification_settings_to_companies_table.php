<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('low_stock_notify_enabled')->default(false);
            $table->unsignedInteger('low_stock_threshold')->default(10);
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['low_stock_notify_enabled', 'low_stock_threshold']);
        });
    }
};
