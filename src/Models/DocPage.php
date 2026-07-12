<?php

declare(strict_types=1);

namespace Magna\Docs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocPage extends Model
{
    protected $table = 'docs_pages';

    protected $fillable = [
        'collection_id',
        'parent_id',
        'title',
        'slug',
        'excerpt',
        'featured_image',
        'meta_title',
        'meta_description',
        'content',
        'status',
        'order',
        'is_published',
        'published_at',
        'show_featured_image',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'show_featured_image' => 'boolean',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(DocCollection::class, 'collection_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(DocPageTranslation::class, 'doc_page_id');
    }

    public function breadcrumb(): array
    {
        $trail = [];
        $node = $this;
        // Guard against a cyclic parent_id (e.g. A→B→A), which would otherwise
        // loop forever and hang the request. Stop if we revisit a page id.
        $seen = [];

        while ($node && ! isset($seen[$node->id])) {
            $seen[$node->id] = true;
            array_unshift($trail, [
                'title' => $node->title,
                'slug' => $node->slug,
            ]);
            $node = $node->parent;
        }

        return $trail;
    }

    public function readingTimeMinutes(): int
    {
        $words = str_word_count(strip_tags((string) $this->content));

        return (int) max(1, round($words / 200));
    }
}
