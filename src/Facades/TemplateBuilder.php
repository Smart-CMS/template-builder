<?php

namespace SmartCms\TemplateBuilder\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SmartCms\TemplateBuilder\TemplateBuilder
 */
class TemplateBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SmartCms\TemplateBuilder\TemplateBuilder::class;
    }
}
