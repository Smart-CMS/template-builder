<?php

namespace SmartCms\TemplateBuilder\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeVariableTypeCommand extends GeneratorCommand
{
    protected $name = 'make:variable-type';

    protected $type = 'VariableType';

    protected $description = 'Make variable type for template builder';

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/variable-type.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\VariableTypes';
    }
}
