<?php

declare(strict_types=1);

namespace DeGraciaMathieu\Tests\Unit;

use DeGraciaMathieu\FileExplorer\File;
use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{
    /** 
     * @test 
     */
    public function it_can_return_its_values(): void
    {
        $file = new File('foo/bar/baz.php', 'bar/baz.php');

        $this->assertSame('foo/bar/baz.php', $file->fullPath);
        $this->assertSame('bar/baz.php', $file->displayPath);
    }

    /** 
     * @test 
     */
    public function it_can_get_file_contents(): void
    {
        $file = new File(__DIR__ . '/Assets/Bar.php', 'Bar.php');

        $this->assertIsString($file->contents());
    }
}
