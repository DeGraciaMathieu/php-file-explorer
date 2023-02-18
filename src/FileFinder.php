<?php

declare(strict_types=1);

namespace DeGraciaMathieu\FileExplorer;

use Generator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class FileFinder
{
    public function __construct(
        private string $basePath,
        private array $fileExtensions = ['php'], 
        private array $ignorePatterns = [],  
        private array $onlyPatterns = [], 
    ) {}

    /**
     * Recursively finds all files with the .php extension in the provided
     * $paths and returns list as Generator.
     */
    public function getFiles(array|string $paths): Generator
    {
        $paths = is_array($paths) ? $paths :  [$paths];

        foreach ($paths as $path) {
            
            $absolutePath = FileHelper::toAbsolutePath($path, $this->basePath);

            yield from $this->getFilesFromPath($absolutePath);
        }
    }

    /**
     * Recursively finds all files with the .php extension in the provided
     * $path adds them to $this->files.
     *
     * @param string $path Path in which to look for .php files.
     * @return Generator<int, File>
     */
    private function getFilesFromPath(string $path): Generator
    {
        if (is_file($path)) {

            $file = new SplFileInfo($path);

            yield new File((string) $file->getRealPath(), $this->getDisplayPath($file));

            return;
        }

        # invalid dir path
        if (! is_dir($path)) {
            return;
        }

        foreach ($this->findFiles($path) as $file) {
            yield new File((string) $file->getRealPath(), $this->getDisplayPath($file));
        }
    }

    /**
     * @param SplFileInfo $file The file object.
     * @return string The file path to display.
     */
    private function getDisplayPath(SplFileInfo $file): string
    {
        return FileHelper::toRelativePath($file->getPathname(), $this->basePath);
    }

    /**
     * Recursively finds all files in a given directory.
     *
     * @param string $path Path in which to look for .php files.
     * @return Generator<int, SplFileInfo>
     */
    private function findFiles(string $path): Generator
    {
        $directoryIterator = new RecursiveDirectoryIterator($path);

        foreach (new RecursiveIteratorIterator($directoryIterator) as $item) {

            if (! $item instanceof SplFileInfo || $item->isDir()) {
                continue;
            }

            if ($this->fileShouldBeSkipped($item)) {
                continue;
            }

            yield $item;
        }
    }

    private function fileShouldBeSkipped(SplFileInfo $item): bool
    {
        if ($this->fileHasWrongExtension($item)) {
            return true;
        }

        $realPath = $item->getRealPath();

        if ($this->fileShouldBeIgnored($realPath)) {
            return true;
        }

        if ($this->onlyPatterns) {
            return $this->fileShouldBeKept($realPath);
        }

        return false;
    }

    private function fileHasWrongExtension(SplFileInfo $item): bool
    {
        return ! in_array($item->getExtension(), $this->fileExtensions, true);
    }

    private function fileShouldBeIgnored(string $realPath): bool
    {
        foreach ($this->ignorePatterns as $regex) {

            if (preg_match("#{$regex}#", $realPath)) {
                return true;
            }
        }

        return false;
    }

    private function fileShouldBeKept(string $realPath): bool
    {
        foreach ($this->onlyPatterns as $regex) {

            if (preg_match("#{$regex}#", $realPath)) {
                return false;
            }
        }

        return true;
    }
}