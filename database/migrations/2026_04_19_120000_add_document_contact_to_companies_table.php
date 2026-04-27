<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('document_contact_name', 150)->nullable()->after('footer_contacts');
            $table->string('document_contact_email', 255)->nullable()->after('document_contact_name');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['document_contact_name', 'document_contact_email']);
        });
    }
};
