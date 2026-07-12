<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docs_page_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('doc_page_id')->constrained('docs_pages')->cascadeOnDelete();
            $table->string('locale', 10);
            $table->string('title');
            $table->longText('content')->nullable();
            $table->timestamps();

            $table->unique(['doc_page_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docs_page_translations');
    }
};
