[![PHP Composer](https://github.com/DeGraciaMathieu/php-file-explorer/actions/workflows/build.yml/badge.svg)](https://github.com/DeGraciaMathieu/php-file-explorer/actions/workflows/build.yml)
[![packagist](https://img.shields.io/packagist/v/DeGraciaMathieu/php-file-explorer)]([https://github.com/DeGraciaMathieu/php-file-explorer/actions/workflows/build.yml](https://img.shields.io/packagist/v/DeGraciaMathieu/php-file-explorer))
[![packagist](https://img.shields.io/packagist/dependency-v/degraciamathieu/php-file-explorer/php)]([https://img.shields.io/packagist/dependency-v/degraciamathieu/php-file-explorer/php](https://img.shields.io/packagist/dependency-v/degraciamathieu/php-file-explorer/php))
# php-file-explorer
Code extracted from [bmitch/churn-php](https://github.com/bmitch/churn-php)
> composer require degraciamathieu/php-file-explorer
## Usage
```php
$fileFinder = new FileFinder(
    fileExtensions: ['php'], 
    filesToIgnore: [], 
    basePath: __DIR__,
);

$files = $fileFinder->getFiles(paths: [
   __DIR__,
]);

foreach ($files as $file) {
   $file->getFullPath();
   $file->getDisplayPath();
}
```
## Tests
```
make test
make coverage
```
