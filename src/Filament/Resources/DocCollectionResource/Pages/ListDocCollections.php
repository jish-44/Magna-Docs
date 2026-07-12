<?php

declare(strict_types=1);

namespace Magna\Docs\Filament\Resources\DocCollectionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Magna\Docs\Filament\Resources\DocCollectionResource;

class ListDocCollections extends ListRecords
{
    protected static string $resource = DocCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
