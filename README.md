# yocLib - OEmbed (PHP)

This yocLibrary enables your project to encode and decode OEmbed data in PHP.

## Status

[![PHP Composer](https://github.com/yocto/yoclib-oembed-php/actions/workflows/php.yml/badge.svg)](https://github.com/yocto/yoclib-oembed-php/actions/workflows/php.yml)
[![codecov](https://codecov.io/gh/yocto/yoclib-oembed-php/graph/badge.svg)](https://codecov.io/gh/yocto/yoclib-oembed-php)

## Installation

`composer require yocto/yoclib-oembed`

## Usage

### Encoding

```php
use YOCLIB\OEmbed\OEmbed;

$data = [
    'version' => '1.0',
];

$json = OEmbed::encode($data,'json');
// or
$xml = OEmbed::encode($data,);
```

### Decoding

```php
use YOCLIB\OEmbed\OEmbed;

$json = '{"version":"1.0"}';
$data = OEmbed::decode($json,'json');

// or

$xml = '<oembed><version>1.0</version></oembed>';
$data = OEmbed::decode($xml);
```