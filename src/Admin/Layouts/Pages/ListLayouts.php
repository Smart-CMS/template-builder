<?php

namespace SmartCms\TemplateBuilder\Admin\Layouts\Pages;

use Filament\Resources\Pages\ListRecords;
use SmartCms\TemplateBuilder\Actions\TemplateParser;
use SmartCms\TemplateBuilder\Admin\Layouts\LayoutResource;
use SmartCms\TemplateBuilder\Models\Layout;
use SmartCms\TemplateBuilder\Support\TemplateTypeEnum;

class ListLayouts extends ListRecords
{
    protected static string $resource = LayoutResource::class;

    public function mount(): void
    {
        parent::mount();
        $this->syncLayoutsFromFilesystem();
    }

    private function syncLayoutsFromFilesystem(): void
    {
        $components = TemplateParser::make(TemplateTypeEnum::LAYOUT)->getAll();
        $layouts = Layout::query()->select(['id', 'name', 'path'])->get();

        // Create indexed collections for efficient lookups
        $componentsByPath = $components->keyBy('path');
        $layoutsByPath = $layouts->keyBy('path');

        // Find paths that exist in filesystem but not in database (to create)
        $pathsToCreate = $componentsByPath->keys()->diff($layoutsByPath->keys());

        // Find paths that exist in database but not in filesystem (to delete)
        $pathsToDelete = $layoutsByPath->keys()->diff($componentsByPath->keys());

        // Find paths that exist in both but may have name changes (to update)
        $pathsToUpdate = $componentsByPath->keys()->intersect($layoutsByPath->keys());

        // Bulk delete layouts that no longer exist in filesystem
        if ($pathsToDelete->isNotEmpty()) {
            Layout::query()->whereIn('path', $pathsToDelete)->delete();
        }

        // Bulk create new layouts
        if ($pathsToCreate->isNotEmpty()) {
            $layoutsToCreate = $pathsToCreate->map(function ($path) use ($componentsByPath) {
                $component = $componentsByPath->get($path);
                Layout::query()->create([
                    'name' => $component['name'] ?? $path,
                    'path' => $path,
                    'value' => [],
                ]);
            });
        }

        // Bulk update existing layouts with name changes
        if ($pathsToUpdate->isNotEmpty()) {
            $updates = [];
            foreach ($pathsToUpdate as $path) {
                $component = $componentsByPath->get($path);
                $layout = $layoutsByPath->get($path);

                // Only update if name has changed
                if ($component['name'] !== $layout['name']) {
                    $updates[] = [
                        'id' => $layout['id'],
                        'name' => $component['name'],
                    ];
                }
            }

            // Perform bulk updates
            if (!empty($updates)) {
                foreach ($updates as $update) {
                    Layout::query()->where('id', $update['id'])->update([
                        'name' => $update['name'],
                    ]);
                }
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
