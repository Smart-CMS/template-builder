<?php

namespace SmartCms\TemplateBuilder\Traits;

use SmartCms\TemplateBuilder\Models\Template;

/**
 * Trait HasTemplate
 */
trait HasTemplate
{
    /**
     * Get the template relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function template()
    {
        return $this->morphOne(Template::class, 'entity');
    }
}
