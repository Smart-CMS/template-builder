<?php

namespace SmartCms\TemplateBuilder\VariableTypes;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use SmartCms\TemplateBuilder\Support\VariableTypeInterface;

class LinkType implements VariableTypeInterface
{
    public static function make(): self
    {
        return new self;
    }

    public static function getName(): string
    {
        return 'link';
    }

    public function getDefaultValue(): mixed
    {
        return url('/');
    }

    public function getSchema(string $name): Field
    {
        return TextInput::make($name)->url();
    }

    public function getValue(mixed $value): mixed
    {
        return asset($value);
    }
}
