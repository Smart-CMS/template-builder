<?php

namespace SmartCms\TemplateBuilder\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use SmartCms\TemplateBuilder\Support\TemplateTypeEnum;
use SmartCms\TemplateBuilder\Support\VariableTypeRegistry;

class TemplateParser
{
    public function __construct(private TemplateTypeEnum $type, private VariableTypeRegistry $variableTypeRegistry) {}

    public static function make(TemplateTypeEnum $type): self
    {
        return new self($type, app(VariableTypeRegistry::class));
    }

    public function parse(string $path): array
    {
        return [
            'name' => ParseNameDirective::run($path),
            'path' => str_replace(resource_path('views/'), '', $path),
            'schema' => ParseSchemaDirective::run($path),
        ];
    }

    public function getAll(): Collection
    {
        return once(function () {
            $path = $this->type->getPath();
            $files = File::allFiles($path);

            return collect($files)->map(fn ($file) => $this->parse($file->getRealPath()));
        });
    }

    public function getComponentSchema(?string $path): array
    {
        if (! $path) {
            return [];
        }
        $schema = ParseSchemaDirective::run(resource_path('views/' . $path));
        $filamentSchema = [];
        foreach ($schema as $name => $rules) {
            $rules = explode('|', $rules);
            $validation = array_slice($rules, 1);
            if (count($rules) < 1) {
                throw new \InvalidArgumentException("Invalid rules for variable $name");
            }
            $type = $this->variableTypeRegistry->get($rules[0]);
            if (! $type) {
                throw new \InvalidArgumentException("Invalid type {$rules[0]} for variable $name");
            }
            $variableSchema = $this->variableTypeRegistry->getSchema($name, $rules[0], implode('|', $validation), fullSchema: $schema);
            if ($variableSchema) {
                $filamentSchema[] = $variableSchema;
            }
        }

        return $filamentSchema;
    }

    public function getComponentVariables(?string $path, array $values = []): array
    {
        if (! $path) {
            return [];
        }
        $schema = ParseSchemaDirective::run(resource_path('views/' . $path));
        $variables = [];
        foreach ($schema as $name => $rules) {
            $rules = explode('|', $rules);
            if (count($rules) < 1) {
                throw new \InvalidArgumentException("Invalid rules for variable $name");
            }
            if (str_contains($name, '.*.')) {
                continue;
            }
            $value = $values[$name] ?? null;
            if (app('lang')->adminLanguages()->count() > 1) {
                $value = $values[current_lang()][$name] ?? $value;
            }
            $variables[$name] = $this->variableTypeRegistry->getVariable($name, $rules[0], $value, $schema);
        }

        return $variables;
    }
}
