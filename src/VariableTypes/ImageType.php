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
        return false;
    }

    public function getSchema(string $name): Field | Component
    {
        return ImageUpload::make($name);
    }

    public function getValue(mixed $value): mixed
    {
        return $value ?? false;
    }
}
