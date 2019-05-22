## ![logo-40](https://user-images.githubusercontent.com/17793990/58057514-104d5c80-7ba0-11e9-8b58-fbf70ab9d6fe.png) Laravel ArtisanBrowser

Composer package that allows you to run laravel's artisan commnd with input completion on your browser.

It is a developer tool that displays a console with commonly used route display and completion and input history display of artisan command.

**warning**: Use this package only in development. It is dangerous because the artist command can be executed from the browser.

![https://img.shields.io/badge/license-MIT-green.svg](https://img.shields.io/badge/license-MIT-green.svg)![Packagist Version](https://img.shields.io/packagist/v/temori/artisan-browser.svg)![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/temori1919/artisanbrowser.svg)

![](https://user-images.githubusercontent.com/17793990/57972369-476f1280-79d4-11e9-9918-dfddb07a2d80.gif)



## Table of Contents

* [Requirements](#requirements)

* [Installation](#Installation)

* [Configuration](#Configuration)

* [Availability](#Availability)

* [License](#license)

  

## Requirements

- Laravel 5.5.0 or later

  

## Installation

```sh
cd path/to/your/project
composer require temori/artisan-browser --dev
```



## Configuration

This package has  some settings.



- artisanbrowser enabled or disabled

- Number of past commands retained and history log path.
- The middleware in this package passes all requests, but you can manually add the URLs you want to exclude.



If you want to override the settings, publish the config file.

```sh
php artisan vendor:publish --provider="Temori\ArtisanBrowser\ArtisanBrowserServiceProvider"
```

Then, edit config file.



## Availability

1. Drag an icon to display a window. (saveing an icon position in localstorage)
2. Always show route.
3. Completion of artisan command.
4. Complement using history of artisan command.



License
-------

Paddington is licensed under the [MIT](https://opensource.org/licenses/mit-license.php) license.  
Copyright &copy; 2019, Atushi Inoue