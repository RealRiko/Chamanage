<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('personal_monthly_goal', 12, 2)->nullable();
            $table->string('personal_goal_type', 32)->default('revenue');
            $table->unsignedTinyInteger('dashboard_chart_months')->default(6);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'personal_monthly_goal',
                'personal_goal_type',
                'dashboard_chart_months',
            ]);
        });
    }
};
