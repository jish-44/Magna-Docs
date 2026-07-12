<?php

declare(strict_types=1);

namespace Magna\Docs\Filament\Resources\DocPageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Magna\Docs\Filament\Resources\DocPageResource;

class ListDocPages extends ListRecords
{
    protected static string $resource = DocPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
