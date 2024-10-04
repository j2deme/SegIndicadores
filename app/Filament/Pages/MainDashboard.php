<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MainDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Inicio';
    protected static string $view = 'filament.pages.main-dashboard';
}
