<?php

namespace SmartCms\TemplateBuilder\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeSectionCommand extends GeneratorCommand
{
    protected $name = 'make:section';

    protected $type = 'Section';

    protected $description = 'Make section for template builder';

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/section.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'resources/views/sections';
    }

    protected function qualifyClass($name)
    {
        return $name;
    }

    protected function getPath($name)
    {
        return $this->viewPath(
            'sections/' .
                $this->getNameInput() . '.' . $this->option('extension'),
        );
    }

    protected function getNameInput()
    {
        $name = trim($this->argument('name'));

        $name = str_replace(['\\', '.'], '/', $name);

        return $name;
    }

    protected function buildClass($name)
    {
        return str_replace(
            ['{{ $name }}'],
            [$name],
            file_get_contents($this->getStub())
        );
    }

    protected function getOptions()
    {
        return [
            ['extension', null, InputOption::VALUE_OPTIONAL, 'The extension of the generated view', 'blade.php'],
            ['force', 'f', InputOption::VALUE_NONE, 'Create the view even if the view already exists'],
        ];
    }
}
