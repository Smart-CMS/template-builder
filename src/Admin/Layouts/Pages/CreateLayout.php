<?php

namespace SmartCms\TemplateBuilder\Admin\Layouts\Pages;

use Filament\Resources\Pages\CreateRecord;
use SmartCms\TemplateBuilder\Admin\Layouts\LayoutResource;

class CreateLayout extends CreateRecord
{
    protected static string $resource = LayoutResource::class;
}
