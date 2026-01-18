<?php

namespace App\Filament\Public\Resources\BookResource\Pages;

use App\Filament\Public\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;
}
