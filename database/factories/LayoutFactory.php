<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SmartCms\TemplateBuilder\Models\Layout;

class LayoutFactory extends Factory
{
    protected $model = Layout::class;

    public function definition(): array
    {
        return [
            'name' => str()->random(rand(3, 10)),
            'path' => str()->random(rand(3, 10)),
            'value' => [],
        ];
    }
}
