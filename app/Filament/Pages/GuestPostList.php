<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GuestPostList extends Page
{
    protected static string $view = 'filament.pages.guest-post-list';

    public static function getSlug(): string
    {
        return 'guest'; // accessible at root URL
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // hides from sidebar
    }

    public static function canAccess(): bool
    {
        return true; // allows access without login
    }


}
