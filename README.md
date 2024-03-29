# Authorization

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tipoff/authorization.svg?style=flat-square)](https://packagist.org/packages/tipoff/authorization)
![Tests](https://github.com/tipoff/authorization/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tipoff/authorization.svg?style=flat-square)](https://packagist.org/packages/tipoff/authorization)

This Laravel package contains an opinionated implementation of Authorization allowing users to have multiple email addresses and unique usernames.

## Installation

Before installing the package, you must first [install Laravel Nova](https://github.com/laravel/nova-docs/blob/master/3.0/installation.md#installing-nova-via-composer).

You can install the package via composer:

```bash
composer require tipoff/authorization
```

The migrations will run from the package. You can extend the Models from the package if you need additional classes or functions added to them.

This package requires the following additions to your Laravel repo's config/auth.php

```php
    'guards' => [
        // ...
        'email' => [
            'driver' => 'session',
            'provider' => 'email',
        ],
        // ...
   ],
   // ...
    'providers' => [
        // ...
        'users' => [
            'driver' => 'tipoff',
            'model' => Tipoff\Authorization\Models\User::class,
        ],
        // ...
        'email' => [
            'driver' => 'eloquent',
            'model' => Tipoff\Authorization\Models\EmailAddress::class,
        ],        
        // ...
   ],
   // ...
```

For developing Laravel applications, it is recommended to create a migration with an admin user.

## Models

We include the following models:

**List of Models**

- Email Address
- User

For each of these models, this package implements an [authorization policy](https://laravel.com/docs/8.x/authorization) that extends the roles and permissions approach of the [tipoff/authorization](https://github.com/tipoff/authorization) package. The policies for each model in this package are registered through the package and do not need to be registered manually.

The models also have [Laravel Nova resources](https://nova.laravel.com/docs/3.0/resources/) in this package and they are also registered through the package and do not need to be registered manually.

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
