<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SmartCms\TemplateBuilder\Models\Section;
use SmartCms\TemplateBuilder\Models\Template;

class TemplateFactory extends Factory
{
    protected $model = Template::class;

    public function definition(): array
    {
        return [
            'template_section_id' => Section::factory(),
            'sorting' => rand(1, 100),
            'status' => rand(0, 1),
            'value' => [],
        ];
    }
}
