<?php

namespace SmartCms\TemplateBuilder\Admin\Sections\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use SmartCms\TemplateBuilder\Actions\TemplateParser;
use SmartCms\TemplateBuilder\Support\TemplateTypeEnum;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        $components = TemplateParser::make(TemplateTypeEnum::SECTION)->getAll();

        return $schema
            ->components([
                Grid::make()
                    ->gridContainer()
                    ->columns([
                        '@md' => 3,
                        '@xl' => 3,
                    ])
                    ->schema([
                        Grid::make(1)->schema([
                            Section::make()->schema([
                                TextInput::make('name')
                                    ->label(__('template-builder::admin.name'))
                                    ->required(),
                                Select::make('path')->options($components->pluck('name', 'path')->toArray())->required()->live(),
                            ])->columns(2)->columnSpan(1),
                            Grid::make(1)
                                ->schema(function (Get $get): array {
                                    $path = $get('path');

                                    return [
                                        TextEntry::make('section_is_empty')->state(__('template-builder::admin.empty_content'))->hiddenLabel()->hidden(! blank($path)),
                                        ...TemplateParser::make(TemplateTypeEnum::SECTION)->getComponentSchema($path),
                                    ];
                                })->live()
                                ->columnSpanFull()->key('dynamicTypeFields'),
                        ])->columnSpan(2),
                        Section::make([
                            TextEntry::make('created_at')->inlineLabel()->since(),
                            TextEntry::make('updated_at')->inlineLabel()->since(),
                            Toggle::make('status')->label(__('template-builder::admin.status')),
                        ])->columnSpan(1)->hiddenOn('create'),
                    ]),
            ])->columns(1);
    }
}
