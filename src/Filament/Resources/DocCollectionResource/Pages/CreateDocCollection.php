<?php

declare(strict_types=1);

namespace Magna\Docs\Filament\Resources\DocCollectionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Magna\Docs\Filament\Resources\DocCollectionResource;

class CreateDocCollection extends CreateRecord
{
    protected static string $resource = DocCollectionResource::class;
}
