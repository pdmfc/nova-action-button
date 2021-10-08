# Nova Action Button

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pdmfc/nova-action-button?style=flat-square)](https://packagist.org/packages/pdmfc/nova-action-button)
![Licence](https://img.shields.io/github/license/pdmfc/nova-action-button?style=flat-square)
[![Total Downloads](https://poser.pugx.org/pdmfc/nova-action-button/downloads?format=flat-square)](https://packagist.org/packages/pdmfc/nova-action-button)

This package allows you to execute an action directly on your resource table view.

## Installation

```shell
composer require pdmfc/nova-action-button
```

## Usage

```php
use App\Nova\Actions\ChangeRole;
use Pdmfc\NovaFields\ActionButton;

//...

public function fields()
{
    return [
        ActionButton::make('Action')
            ->action(ChangeRole::class, $this->id)
            //->action(new ChangeRole(), $this->id) using a new instance
    ];
}
```

The `action()` method requires two params - the action class name or a new instance, and the target resource id.

## ![Basic example](images/basic_example.png)

### Disabling button

You can use the native Laravel nova [readonly()](https://nova.laravel.com/docs/3.0/resources/fields.html#readonly-fields) method to prevent users from clicking the button:

```php
ActionButton::make('Action')
    ->action(ChangeRole::class, $this->id)
    ->readonly(function () {
        return $this->role->name === 'admin';
    })
```

![Disabling the button](images/disable_example.png)

### Change the button text

To edit the button text content, use the `text()` method.
```php
->text('Execute')
```

### Enable the loading animation on button and change color

To enable the loading animation on button and change color, use `showLoadingAnimation()` and `loadingColor('#fff')` method.
```php
->showLoadingAnimation()
->loadingColor('#fff') # default is #000
```

### Add a svg to the button

In order to add a svg to the button, you first need to create a vue component containing a svg and then pass the component name to the `svg()` method.
```php
->svg('VueComponentName')
```

## Caveats

- Currently, in order to use this field, you still have to declare the action in your resource `actions()` method.

## How to contribute

- clone the repo
- on `composer.json` of a laravel nova application add the following:

```
{
    //...

    "require" {
        "pdmfc/nova-action-button: "*"
    },

    //...
    "repositories": [
        {
            "type": "path",
            "url": "../path_to_your_package_folder"
        }
    ],
}
```

- run `composer update pdmfc/nova-action-button`

You're now ready to start contributing!

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
