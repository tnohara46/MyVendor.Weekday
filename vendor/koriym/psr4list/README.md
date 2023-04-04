# Koriym.Psr4List
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/koriym/Koriym.Psr4List/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/koriym/Koriym.Psr4List/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/koriym/Koriym.Psr4List/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/koriym/Koriym.Psr4List/?branch=master)
[![Build Status](https://travis-ci.org/koriym/Koriym.Psr4List.svg?branch=master)](https://travis-ci.org/koriym/Koriym.Psr4List)

It gets the name of each of the files and class names of a particular PSR4 path.

## Installation

```bash
$ composer require koriym/psr4list
```

## Usage

```php
use Koriym\Psr4List;

$list = new Psr4List;
$prefix = 'BEAR\Sunday';
$path = __DIR__ . '/src';

foreach ($list($prefix, $path) as list($class, $file)) {
    var_dump($class);
    var_dump($file);
}
```

