<?php

namespace SmartCms\TemplateBuilder\VariableTypes;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use SmartCms\TemplateBuilder\Support\VariableTypeInterface;

class TextType implements VariableTypeInterface
{
    public static function make(): self
    {
        return new self;
    }

    public static function getName(): string
    {
        return 'text';
    }

    public function getDefaultValue(): mixed
    {
        return '';
    }

    public function getSchema(string $name): Field | Component
    {
        return TextInput::make($name);
    }

    public function getValue(mixed $value): mixed
    {
        return $value ?? '';
    }
}
