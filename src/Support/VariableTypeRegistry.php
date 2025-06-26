<?php

namespace SmartCms\TemplateBuilder\Support;

use Filament\Schemas\Components\Section;
use InvalidArgumentException;
use SmartCms\TemplateBuilder\VariableTypes\BoolType;
use SmartCms\TemplateBuilder\VariableTypes\LinkType;
use SmartCms\TemplateBuilder\VariableTypes\TextType;

class VariableTypeRegistry
{
    protected array $types = [];

    public bool $shouldThrowError = true;

    public function __construct()
    {
        $this->register(TextType::class);
        $this->register(BoolType::class);
        $this->register(LinkType::class);
    }

    public function register(string $class): void
    {
        if (! is_subclass_of($class, VariableTypeInterface::class)) {
            throw new InvalidArgumentException("Class $class must implement VariableTypeInterface");
        }

        $this->types[$class::getName()] = $class;
    }

    public function get(string $name): ?VariableTypeInterface
    {
        if (! isset($this->types[$name])) {
            return null;
        }

        return app($this->types[$name]);
    }

    public function all(): array
    {
        return $this->types;
    }

    public function getSchema(string $name, string $type, string $validation = '', string $prefix = 'value.'): ?Section
    {
        $type = $this->get($type);
        if (! $type) {
            if ($this->shouldThrowError) {
                throw new \InvalidArgumentException("Invalid type for variable $name");
            }

            return null;
        }
        $isRequired = str_contains($validation, 'required');

        return Section::make($this->getLabelFromName($name))->compact()->schema([
            $type->getSchema($prefix . $name)
                ->required($isRequired)
                ->rules($validation)
                ->hiddenLabel(),
        ]);
    }

    public function getVariable(string $name, string $type, mixed $value): mixed
    {
        $type = $this->get($type);
        if (! $type) {
            if ($this->shouldThrowError) {
                throw new \InvalidArgumentException("Invalid type for variable $name");
            }

            return null;
        }

        return $type->getValue($value);
    }

    public function getLabelFromName(string $name): string
    {
        return str($name)->replace('_', ' ')->ucfirst()->toString();
    }
}
