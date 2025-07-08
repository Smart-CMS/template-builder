<?php

namespace SmartCms\TemplateBuilder\Admin\Layouts\Pages;

use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use SmartCms\Support\Admin\Components\Actions\SettingsAction;
use SmartCms\TemplateBuilder\Actions\TemplateParser;
use SmartCms\TemplateBuilder\Admin\Layouts\LayoutResource;
use SmartCms\TemplateBuilder\Models\Layout;
use SmartCms\TemplateBuilder\Support\TemplateTypeEnum;

class ListLayouts extends ListRecords
{
    protected static string $resource = LayoutResource::class;

    public function mount(): void
    {
        parent::mount();
        $components = TemplateParser::make(TemplateTypeEnum::LAYOUT)->getAll();
        $layouts = Layout::query()->pluck('path');
        $diff = $components->pluck('path')->diff($layouts);
        foreach ($diff as $path) {
            Layout::query()->create([
                'name' => $components->firstWhere('path', $path)['name'] ?? $path,
                'path' => $path,
                'value' => [],
            ]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
