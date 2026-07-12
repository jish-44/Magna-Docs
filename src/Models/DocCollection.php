<?php

declare(strict_types=1);

namespace Magna\Docs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocCollection extends Model
{
    protected $table = 'doc_collections';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'color',
        'order',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(DocPage::class, 'collection_id')->orderBy('order');
    }
}
