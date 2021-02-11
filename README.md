# Authorization

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tipoff/authorization.svg?style=flat-square)](https://packagist.org/packages/tipoff/authorization)
![Tests](https://github.com/tipoff/authorization/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tipoff/authorization.svg?style=flat-square)](https://packagist.org/packages/tipoff/authorization)

This is where your description should go.

## Installation

You can install the package via composer:

```bash
composer require tipoff/authorization
```

The migrations will run from the package. You can extend the Models from the package if you need additional classes or functions added to them.

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Tipoff\Authorization\AuthorizationServiceProvider" --tag="config"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$Authorization = new Tipoff\Authorization();
echo $Authorization->echoPhrase('Hello, Tipoff!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tipoff](https://github.com/tipoff)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
