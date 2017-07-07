# yii2-support

[![Build Status](https://travis-ci.org/jarrus90/yii2-support.svg?branch=master)](https://travis-ci.org/jarrus90/yii2-support)

> **NOTE:** Module is in initial development. Anything may change at any time.

## Contributing to this project

Anyone and everyone is welcome to contribute. Please take a moment to review the [guidelines for contributing](CONTRIBUTING.md).

## License

Yii2-support is released under the BSD-3-Clause License. See the bundled [LICENSE.md](LICENSE.md) for details.

##Requirements

YII 2.0

## Usage

1) Install with Composer

~~~php

"require": {
    "jarrus90/yii2-support": "1.*",
},

php composer.phar update

~~~

## Restrict and split frontend and backend applications

```
'modules' => [
    'support' => [
        'as frontend' => 'jarrus90\Support\filters\FrontendFilter',
    ],
],
```
```
'modules' => [
    'support' => [
        'as backend' => 'jarrus90\Support\filters\BackendFilter',
    ],
],
```