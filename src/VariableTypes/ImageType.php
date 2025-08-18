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
            'alt' => 'default image',
        ];
    }

    public function getSchema(string $name): Field | Component
    {
        return ImageUpload::make($name, label: 'Image');
    }

    public function getValue(mixed $value): mixed
    {
        if (!is_array($value)) {
            return $this->getDefaultValue();
        }
        $alt = $value[current_lang()] ?? $value['alt'] ?? __('Default alt');
        if (!isset($value['source']) || !isset($value['width']) || !isset($value['height'])) {
            return $this->getDefaultValue();
        }
        $value['source'] = asset($value['source']);
        $value['alt'] = $alt;
        return $value;
    }
}
