<?php

namespace SmartCms\TemplateBuilder\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SmartCms\TemplateBuilder\Support\TemplateTypeEnum;
use SmartCms\TemplateBuilder\Traits\HasVariables;

/**
 * Class Layout
 *
 * @property int $id The unique identifier for the model.
 * @property string $name The name of the layout.
 * @property string $path The path to the layout template.
 * @property bool $can_be_used Whether the layout can be used.
 * @property bool $status The status of the layout.
 * @property array $schema The schema configuration for the layout.
 * @property array $value The values for the layout configuration.
 * @property \DateTime $created_at The date and time when the model was created.
 * @property \DateTime $updated_at The date and time when the model was last updated.
 */
class Layout extends Model
{
    use HasFactory;
    use HasVariables;

    protected $guarded = [];

    protected $casts = [
        'value' => 'array',
    ];

    public static function getTemplateType(): TemplateTypeEnum
    {
        return TemplateTypeEnum::LAYOUT;
    }
}
