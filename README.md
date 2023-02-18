[![PHP Composer](https://github.com/DeGraciaMathieu/php-file-explorer/actions/workflows/build.yml/badge.svg)](https://github.com/DeGraciaMathieu/php-file-explorer/actions/workflows/build.yml)
[![packagist](https://img.shields.io/packagist/v/DeGraciaMathieu/php-file-explorer)]([https://github.com/DeGraciaMathieu/php-file-explorer/actions/workflows/build.yml](https://img.shields.io/packagist/v/DeGraciaMathieu/php-file-explorer))
[![packagist](https://img.shields.io/packagist/dependency-v/degraciamathieu/php-file-explorer/php)]([https://img.shields.io/packagist/dependency-v/degraciamathieu/php-file-explorer/php](https://img.shields.io/packagist/dependency-v/degraciamathieu/php-file-explorer/php))
# php-file-explorer
Code originally taken from [bmitch/churn-php](https://github.com/bmitch/churn-php)
> composer require degraciamathieu/php-file-explorer
## Usage
```php
use DeGraciaMathieu\FileExplorer\FileFinder;

$fileFinder = new FileFinder(
    basePath: __DIR__,
);

$files = $fileFinder->getFiles();

foreach ($files as $file) {

   # DeGraciaMathieu\FileExplorer\File
   $file->fullPath;
   $file->displayPath;
}
```
```php
$fileFinder = new FileFinder(
    basePath: 'app/Modules/', 
    onlyPatterns: [
        '.*/Logics/.*',
        '.*Logic.php',
    ],
);

$files = $fileFinder->getFiles();
```
```php
$fileFinder = new FileFinder(
    basePath: 'app/Modules/', 
    ignorePatterns: [
        '.*/Repositories/.*',
    ],
);

$files = $fileFinder->getFiles();
```
```php
$fileFinder = new FileFinder(
    basePath: 'app/', 
);

$files = $fileFinder->getFiles([
    'Models/.*',
    'Services/.*',
]);
```
## Tests
```
make test
make coverage
```
