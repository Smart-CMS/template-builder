# This is my package template-builder

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smart-cms/template-builder.svg?style=flat-square)](https://packagist.org/packages/smart-cms/template-builder)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/smart-cms/template-builder/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/smart-cms/template-builder/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/smart-cms/template-builder/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/smart-cms/template-builder/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smart-cms/template-builder.svg?style=flat-square)](https://packagist.org/packages/smart-cms/template-builder)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require smart-cms/template-builder
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="template-builder-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="template-builder-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="template-builder-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Testing

```bash
composer test
```

## Credits

- [maxboyko](https://github.com/SmartCms)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
