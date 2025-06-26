<?php

namespace SmartCms\TemplateBuilder\Admin\Sections\Pages;

use Filament\Resources\Pages\CreateRecord;
use SmartCms\TemplateBuilder\Admin\Sections\SectionResource;

class CreateSection extends CreateRecord
{
    protected static string $resource = SectionResource::class;
}
