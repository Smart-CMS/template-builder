<?php

namespace SmartCms\TemplateBuilder;

use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportTesting\Testable;
use SmartCms\TemplateBuilder\Commands\MakeLayoutCommand;
use SmartCms\TemplateBuilder\Commands\MakeSectionCommand;
use SmartCms\TemplateBuilder\Commands\MakeVariableTypeCommand;
use SmartCms\TemplateBuilder\Support\Template;
use SmartCms\TemplateBuilder\Support\VariableTypeRegistry;
use SmartCms\TemplateBuilder\Testing\TestsTemplateBuilder;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TemplateBuilderServiceProvider extends PackageServiceProvider
{
    public static string $name = 'template-builder';

    public static string $viewNamespace = 'template-builder';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasCommands([
                MakeLayoutCommand::class,
                MakeSectionCommand::class,
                MakeVariableTypeCommand::class,
            ])
            ->hasMigrations([
                'create_layouts_table',
                'create_sections_table',
                'create_templates_table',
            ])
            ->hasConfigFile()
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('smart-cms/template-builder');
            });
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(VariableTypeRegistry::class);
        $this->app->singleton(Template::class);
        $this->app->alias(Template::class, 'template');
    }

    public function packageBooted(): void
    {
        Testable::mixin(new TestsTemplateBuilder);
        Blade::directive('template', function () {
            return "<?php echo app('template')->render(); ?>";
        });
        Blade::directive('schema', function ($expression) {
            return "<?php
            \$_vars = app('template')->provideDefaultVariables($expression);
            foreach (\$_vars as \$_name => \$_value) {
                if (!isset(\$\$_name)) {
                    \$\$_name = \$_value;
                }
            }
                unset(\$_vars);
                unset(\$_name);
                unset(\$_value);
             ?>";
        });
        Blade::directive('name', function (string $expression) {
            return '';
        });
    }
}
