<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doc_collections', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->default('book-open');
            $table->string('color', 20)->default('#6366f1');
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->index('order');
        });

        Schema::table('docs_pages', function (Blueprint $table): void {
            $table->foreignId('collection_id')
                ->nullable()
                ->after('parent_id')
                ->constrained('doc_collections')
                ->nullOnDelete();

            $table->string('status')->default('draft')->after('content');
            $table->string('meta_title')->nullable()->after('excerpt');
            $table->string('meta_description', 500)->nullable()->after('meta_title');

            $table->index('collection_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('docs_pages', function (Blueprint $table): void {
            $table->dropForeign(['collection_id']);
            $table->dropColumn(['collection_id', 'status', 'meta_title', 'meta_description']);
        });

        Schema::dropIfExists('doc_collections');
    }
};
