<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;

class PostOverview extends BaseWidget
{
    // protected static string $view = 'filament.resources.post-resource.widgets.post-overview';

    protected function getCards(): array
    {
        return [
            Card::make('All Post', Post::all()->count())
                ->description('32k increase')
                ->descriptionIcon('heroicon-s-trending-up'),
            Card::make('Publish', Post::where('status', true)->count()),
            Card::make('Draft', Post::where('status', false)->count())
        ];
    }
}
