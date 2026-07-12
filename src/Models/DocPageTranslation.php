<?php

declare(strict_types=1);

namespace Magna\Docs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocPageTranslation extends Model
{
    protected $table = 'docs_page_translations';

    protected $fillable = [
        'doc_page_id',
        'locale',
        'title',
        'content',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(DocPage::class, 'doc_page_id');
    }
}
