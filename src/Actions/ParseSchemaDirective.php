<?php

namespace SmartCms\TemplateBuilder\Actions;

class ParseSchemaDirective
{
    /**
     * Parse the first @schema([...]) directive in a Blade view
     * and return an associative array name=>type.
     *
     * @param  string  $viewPath  Full path to the .blade.php file
     * @return array<string,string>
     */
    public static function run(string $viewPath): array
    {
        if (! file_exists($viewPath)) {
            throw new \InvalidArgumentException("View file not found: {$viewPath}");
        }

        $content = file_get_contents($viewPath);

        // 1) find @schema([ ... ])
        if (! preg_match('/@schema\(\s*\[([\s\S]*?)\]\s*\)/', $content, $m)) {
            return [];
        }

        $insideArray = $m[1];

        // 2) match each 'key:type' or "key:type"
        preg_match_all('/[\'"]([^\'"]+)[\'"]/', $insideArray, $items);

        $result = [];
        foreach ($items[1] as $item) {
            // split into name and type (only on first colon)
            [$name, $type] = array_pad(explode(':', $item, 2), 2, null);

            // you might want to normalize, validate, etc.
            $result[trim($name)] = trim((string) $type);
        }

        return $result;
    }
}
