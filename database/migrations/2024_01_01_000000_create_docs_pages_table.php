<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docs_pages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('docs_pages')
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable();
            $table->longText('content')->nullable(); // Markdown source
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['parent_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docs_pages');
    }
};
