<?php

namespace SmartCms\TemplateBuilder\Support;

use Filament\Forms\Components\Field;

interface VariableTypeInterface
{
    public static function make(): self;

    public static function getName(): string;

    public function getDefaultValue(): mixed;

    public function getSchema(string $name): Field;

    public function getValue(mixed $value): mixed;
}
