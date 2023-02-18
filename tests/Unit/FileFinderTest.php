<?php

declare(strict_types=1);

namespace DeGraciaMathieu\Tests\Unit;

use DeGraciaMathieu\FileExplorer\FileFinder;
use PHPUnit\Framework\TestCase;

final class FileFinderTest extends TestCase
{
    /** 
     * @test 
     * @dataProvider filesWithOnlyFiltersProvider
     */
    public function it_can_get_files_with_only_filters(int $expected, array $onlyPatterns): void
    {
        $fileFinder = new FileFinder(
            basePath: __DIR__, 
            onlyPatterns: $onlyPatterns,
        );

        $files = $fileFinder->getFiles('Assets');

        $files = iterator_to_array($files, false);

        $this->assertCount($expected, $files);
    }

    public function filesWithOnlyFiltersProvider(): iterable
    {
        yield [2, ['.*/Logics/.*']];
        yield [1, ['.*Logic.php']];
        yield [3, ['Bar']];
        yield [4, ['Ba']];
    }

    /** 
     * @test 
     * @dataProvider filesWithIgnoreFiltersProvider
     */
    public function it_can_get_files_with_ignore_filters(int $expected, array $ignorePatterns): void
    {
        $fileFinder = new FileFinder(
            basePath: __DIR__, 
            ignorePatterns: $ignorePatterns,
        );

        $files = $fileFinder->getFiles('Assets');

        $files = iterator_to_array($files, false);

        $this->assertCount($expected, $files);
    }

    public function filesWithIgnoreFiltersProvider(): iterable
    {
        yield [3, ['.*/Logics/.*']];
        yield [4, ['.*Logic.php']];
        yield [2, ['Bar']];
        yield [1, ['Ba']];
    }

    /** 
     * @test 
     */
    public function it_can_get_the_php_files_in_multiple_directories(): void
    {
        $fileFinder = new FileFinder(
            basePath: __DIR__, 
        );

        $files = $fileFinder->getFiles([
            'Assets',
            'Assets2',
        ]);

        $files = iterator_to_array($files, false);

        self::assertCount(7, $files);
    }

    /** 
     * @test 
     */
    public function it_can_get_the_php_files_by_name(): void
    {
        $fileFinder = new FileFinder(
            basePath: __DIR__, 
        );

        $files = $fileFinder->getFiles([
            'Assets/DeepAssets/Logics/Bar.php',
            'Assets2/Deep.php',
        ]);

        $files = iterator_to_array($files, false);

        self::assertCount(2, $files);
    }

    /** 
     * @test 
     */
    public function it_does_not_throw_with_non_existing_path(): void
    {
        $fileFinder = new FileFinder(
            basePath: __DIR__, 
        );

        $files = $fileFinder->getFiles([
            'qdqsdq.php',
        ]);

        $files = iterator_to_array($files, false);

        self::assertCount(0, $files);
    }
}
