# php-file-explorer
Code extracted from [bmitch/churn-php](https://github.com/bmitch/churn-php)

```php
$fileFinder = new FileFinder(
    fileExtensions: ['php'], 
    filesToIgnore: [], 
    basePath: __DIR__,
);

$fileFinder->getPhpFiles(paths: [
   __DIR__,
]);
```
