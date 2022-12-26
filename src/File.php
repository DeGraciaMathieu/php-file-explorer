<?php

declare(strict_types=1);

namespace DeGraciaMathieu\FileExplorer;

final class File
{
    public function __construct(
        private readonly string $fullPath, 
        private readonly string $displayPath,
    ) {}

    public function getFullPath(): string
    {
        return $this->fullPath;
    }

    public function getDisplayPath(): string
    {
        return $this->displayPath;
    }
}