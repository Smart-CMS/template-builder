<?php

namespace SmartCms\TemplateBuilder\Actions;

class ParseNameDirective
{
    /**
     * Parse the first @schema([...]) directive in a Blade view
     * and return an associative array name=>type.
     *
     * @param  string  $viewPath  Full path to the .blade.php file
     */
    public static function run(string $viewPath): string
    {
        if (! file_exists($viewPath)) {
            throw new \InvalidArgumentException("View file not found: {$viewPath}");
        }

        $content = file_get_contents($viewPath);

        if (! preg_match('/@name\(\s*\'([\s\S]*?)\'\s*\)/', $content, $m)) {
            $name = ucfirst(last(explode('/', $viewPath)));

            return str_replace('.blade.php', '', $name);
        }

        return ucfirst($m[1]);
    }
}
