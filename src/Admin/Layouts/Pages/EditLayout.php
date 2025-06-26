<?php

namespace SmartCms\TemplateBuilder\Admin\Layouts\Pages;

use Filament\Resources\Pages\EditRecord;
use SmartCms\TemplateBuilder\Admin\Layouts\LayoutResource;

class EditLayout extends EditRecord
{
    protected static string $resource = LayoutResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
