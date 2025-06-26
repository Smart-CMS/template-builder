<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SmartCms\TemplateBuilder\Models\Section;

class TemplateSectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition(): array
    {
        return [
            'name' => str()->random(rand(3, 10)),
            'path' => str()->random(rand(3, 10)),
            'status' => rand(0, 1),
            'value' => [],
        ];
    }
}
