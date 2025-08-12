<?php

namespace SmartCms\TemplateBuilder\VariableTypes;

use Filament\Forms\Components\Field;
use Filament\Schemas\Components\Component;
use SmartCms\Support\Admin\Components\Forms\ImageUpload;
use SmartCms\TemplateBuilder\Support\VariableTypeInterface;

class ImageType implements VariableTypeInterface
{
    public static function make(): self
    {
        return new self;
    }

    public static function getName(): string
    {
        return 'image';
    }

    public function getDefaultValue(): mixed
    {
        return [
            'width' => 300,
            'height' => 300,
            'source' => asset('favicon.ico'),
            'alt' => 'default image'
        ];
    }

    public function getSchema(string $name): Field | Component
    {
        return ImageUpload::make($name, label: 'Image');
    }

    public function getValue(mixed $value): mixed
    {
        return $value ?? [
            'width' => 300,
            'height' => 300,
            'source' => asset('favicon.ico'),
            'alt' => 'default image'
        ];
    }
}
