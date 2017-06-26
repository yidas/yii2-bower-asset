<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Core Bower Asset</h1>
    <br>
</p>

Bower Assets for Yii 2 core provided via Composer repository

[![Latest Stable Version](https://poser.pugx.org/yidas/yii2-bower-asset/v/stable?format=flat-square)](https://packagist.org/packages/yidas/yii2-bower-asset)
[![Latest Unstable Version](https://poser.pugx.org/yidas/yii2-bower-asset/v/unstable?format=flat-square)](https://packagist.org/packages/yidas/yii2-bower-asset)
[![License](https://poser.pugx.org/yidas/yii2-bower-asset/license?format=flat-square)](https://packagist.org/packages/yidas/yii2-bower-asset)

FEATURES
--------

***1. Install or update Bower assets for Yii2 core via Composer without any plugin***

***2. Prevent the error of Bower packages when using Composer install & update for Yii2***

> Problem 1
>
>   \- yiisoft/yii2 2.0.12 requires bower-asset/jquery 2.2.*@stable | 2.1.*@stable | 1.11.*@stable | 1.12.*@stable -> no matching package found.

***3. Official install way by using original Composer repository***

> Got tired of [fxp/composer-asset-plugin](https://github.com/fxpio/composer-asset-plugin)? It's a good project with nice idea and good implementation. But it has some issues: it slows down composer update a lot and requires global installation, so affects all projects. Also there are Travis and Scrutinizer integration special problems, that are a bit annoying.

According to [Asset Packagist](https://asset-packagist.org/), this package goals to install Bower for Yii2 core by original Composer repository, and makes Bower and Composer separated.

---

INSTALLATION
------------

### 1. Require Package

In Yii2 `composer.json`, require `yidas/yii2-bower-asset` before `yiisoft/yii2`.

Example `composer.json`:

```
"require": {
    "php": ">=5.4.0",
    "yidas/yii2-bower-asset": "~2.0.0",
    "yiisoft/yii2": "~2.0.0",
    "yiisoft/yii2-bootstrap": "~2.0.0"
}
```

After above setting, it's same as [yidas/yii2-composer-bower-skip](https://github.com/yidas/yii2-composer-bower-skip) which makes composer to install and update for Yii2 without Bower plugin.


### 2. Set Up Application Config

In Yii2 application `config/web.php`, added an alias named `@bower` pointed to `@vendor/yidas/yii2-bower-asset/bower`:

```php
$config = [
    ...
    'aliases' => [
        '@bower' => '@vendor/yidas/yii2-bower-asset/bower'
    ],
    ...
];
```

> This method is the better way with efficient and clean considering. Instead, you could also use installer to set up:
> 
> [Install via Package Cloning Installer](#install-via-package-cloning-installer)
>
> [Install via Alias Setting Installer](#install-via-alias-setting-installer)


### 3. Enjoy It

*Finally*, command `composer update` then enjoy it.

---

CREATE PROJECT
--------------

If you doesn't has Yii2 project yet, choose one of below ways to create:

### Create Project via Composer

You can use Composer to create Yii2 project by using following package:  

#### [yidas/yii2-app-basic](https://github.com/yidas/yii2-app-basic)

```
composer create-project --prefer-dist yidas/yii2-app-basic
``` 

#### [yidas/yii2-app-advanced](https://github.com/yidas/yii2-app-advanced)
```
composer create-project --prefer-dist yidas/yii2-app-advanced
```

These packages are Yii 2 Application Template with fixed Bower, which including [`yidas/yii2-bower-asset`](https://github.com/yidas/yii2-bower-asset) already.


### Creating Project from Official Site

You could download Yii2 project from official [Archive File](http://www.yiiframework.com/download/), then manally install `yii2-bower-asset` on it by following above instruction.

---

INSTALLER USAGE
---------------

If you don't want to [Set Up Application Config](#2-set-up-application-config) but use installer instead, there are some ways you could chooses one of them to install:

#### Install via Package Cloning Installer

In Yii2 `composer.json`, add script `yidas\\yii2BowerAsset\\Installer::bower` in `post-package-install` & `post-package-update` event.

```
"scripts": {
    "post-package-install": [
         "yidas\\yii2BowerAsset\\Installer::clone"
    ],
    "post-package-update": [
         "yidas\\yii2BowerAsset\\Installer::clone"
    ]
}
```

#### Install via Alias Setting Installer

In Yii2 `composer.json`, add script `yidas\\yii2BowerAsset\\Installer::setAlias` in `post-update-cmd` event.

```
"scripts": {
    "post-package-install": [
         "yidas\\yii2BowerAsset\\Installer::setAlias"
    ],
    "post-package-update": [
         "yidas\\yii2BowerAsset\\Installer::setAlias"
    ],
    "unset-yii2-bower-asset": [
        "yidas\\yii2BowerAsset\\Installer::unsetAlias"
    ]
}
```

> This installation will modify Yii2 file, you can run `composer run-script unset-yii2-bower-asset` to recover back.

---

LIMITATION
----------

***Do not use Bower mixed with Composer project*** is the goal of this package.

> 1. The variety of Bower packages are just for Yii2 cores. 
>
> 2. The versions of Bower packages are fixed to current Yii2 version.
>
> 3. If you are requiring other Bower packages in Yii2, you could set the config fit to this package or not to use. 
