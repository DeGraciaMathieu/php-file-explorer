<?php

declare(strict_types=1);

namespace DeGraciaMathieu\Tests\Unit;

use DeGraciaMathieu\FileExplorer\FileHelper;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Symfony\Component\Filesystem\Filesystem;

final class FileHelperTest extends TestCase
{
    /**
     * @test
     * @dataProvider provide_absolute_paths
     */
    public function it_can_return_absolute_path(string $path, string $confPath, string $expectedPath): void
    {
        $absolutePath = FileHelper::toAbsolutePath($path, $confPath);

        $this->assertSame($expectedPath, $absolutePath);
    }

    /**
     * @return iterable<int, array{string, string, string}>
     */
    public function provide_absolute_paths(): iterable
    {
        yield ['/tmp', '/path', '/tmp'];
        yield ['foo', '/path', '/path/foo'];
        yield ['foo', 'C:\\path', 'C:\\path/foo'];
        yield ['C:\\foo', '/path', 'C:\\foo'];
        yield ['d:\\foo', '/path', 'd:\\foo'];
        yield ['E:/foo', '/path', 'E:/foo'];
        yield ['f:/foo', '/path', 'f:/foo'];
    }

    /**
     * @test
     * @dataProvider provide_relative_paths
     */
    public function it_can_return_relative_path(string $path, string $confPath, string $expectedPath): void
    {
        $relativePath = FileHelper::toRelativePath($path, $confPath);

        $this->assertSame($expectedPath, $relativePath);
    }

    /**
     * @return iterable<int, array{string, string, string}>
     */
    public function provide_relative_paths(): iterable
    {
        yield ['/tmp/file.php', '/tmp', 'file.php'];
        yield ['/tmp/file.php', '/tmp/', 'file.php'];
        yield ['file.php', '/tmp', 'file.php'];
        yield ['C:/foo/file.php', 'C:/foo', 'file.php'];

        if ('\\' !== \DIRECTORY_SEPARATOR) {
            return;
        }

        yield ['C:\\foo\\file.php', 'C:\\foo\\', 'file.php'];
    }

    /**
     * @test
     * @dataProvider provide_writable_paths
     * @param string $filePath The file path to check.
     */
    public function it_can_ensure_a_file_is_writable(string $filePath): void
    {
        $dirPath = \dirname($filePath);

        FileHelper::ensureFileIsWritable($filePath);

        $this->assertTrue(\is_dir($dirPath), 'Directory should exist: ' . $dirPath);
    }

    /**
     * @return iterable<int, array{string}>
     */
    public function provide_writable_paths(): iterable
    {
        yield [__FILE__];
        yield [__DIR__ . '/non-existing-file'];
        yield [__DIR__ . '/path/to/non-existing-file'];
    }

    /**
     * @test
     * @dataProvider provide_invalid_writable_paths
     * @param string $filePath The file path to check.
     */
    public function it_throws_with_invalid_writable_files(string $filePath): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        FileHelper::ensureFileIsWritable($filePath);
    }

    /**
     * @return iterable<int, array{string}>
     */
    public function provide_invalid_writable_paths(): iterable
    {
        yield [''];
        yield [__DIR__];
    }
}