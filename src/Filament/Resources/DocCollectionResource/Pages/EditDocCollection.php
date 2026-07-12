<?php

declare(strict_types=1);

namespace Magna\Docs\Filament\Resources\DocCollectionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Magna\Docs\Filament\Resources\DocCollectionResource;

class EditDocCollection extends EditRecord
{
    protected static string $resource = DocCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
