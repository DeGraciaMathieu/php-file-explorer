<?php

declare(strict_types=1);

namespace DeGraciaMathieu\Tests\Unit;

use DeGraciaMathieu\FileExplorer\File;
use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{
    /** @test */
    public function it_can_return_its_values(): void
    {
        $file = new File('foo/bar/baz.php', 'bar/baz.php');

        self::assertSame('foo/bar/baz.php', $file->getFullPath());
        self::assertSame('bar/baz.php', $file->getDisplayPath());
    }
}
