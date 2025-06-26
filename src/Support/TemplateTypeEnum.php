<?php

namespace SmartCms\TemplateBuilder\Support;

enum TemplateTypeEnum: string
{
    case SECTION = 'section';
    case LAYOUT = 'layout';

    public function getLabel(): string
    {
        return match ($this) {
            self::SECTION => __('template-builder::admin.section'),
            self::LAYOUT => __('template-builder::admin.layout'),
        };
    }

    public function getPath(): string
    {
        return resource_path('views/' . $this->value . 's');
    }
}
