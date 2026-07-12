<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('docs_pages', function (Blueprint $table): void {
            $table->boolean('show_featured_image')->default(true)->after('featured_image');
        });
    }

    public function down(): void
    {
        Schema::table('docs_pages', function (Blueprint $table): void {
            $table->dropColumn('show_featured_image');
        });
    }
};
