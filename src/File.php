<?php

declare(strict_types=1);

namespace DeGraciaMathieu\FileExplorer;

final class File
{
    public function __construct(
        public readonly string $fullPath, 
        public readonly string $displayPath,
    ) {}

    public function contents(): string
    {
        return file_get_contents($this->fullPath);
    }
}
