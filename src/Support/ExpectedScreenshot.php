<?php

declare(strict_types=1);

namespace Pest\Browser\Support;

use Pest\TestSuite;

/**
 * @internal
 */
final class ExpectedScreenshot
{
    public static function dir(): string
    {
        return TestSuite::getInstance()->rootPath
            .'/tests/.snapshots/screenshots';
    }
    public static function path(string $filename): string
    {
        $filename = self::dir().'/'.mb_ltrim($filename, '/');

        // check if there is extension, if not, add .png
        if (pathinfo($filename, PATHINFO_EXTENSION) === '') {
            $filename .= '.png';
        }

        return $filename;
    }

    public static function filename(): string
    {
        return str_replace('__pest_evaluable__', '', test()->name());
    }

    /**
     * Save a screenshot to the filesystem.
     */
    public static function save(string $binary, ?string $filename = null): string
    {
        $decodedBinary = (string) base64_decode($binary, true);

        if ($filename === null) {
            // @phpstan-ignore-next-line
            $filename = self::filename();
        }

        if (is_dir(self::dir()) === false) {
            mkdir(self::dir(), 0755, true);
        }

        file_put_contents(self::path($filename), $decodedBinary);

        return $decodedBinary;
    }

    /**
     * Clean up the screenshots directory.
     */
    public static function cleanup(): void
    {
        if (is_dir(self::dir()) === false) {
            return;
        }

        $files = glob(self::dir().'/*.png');

        if (is_array($files)) {
            foreach ($files as $file) {
                unlink($file);
            }
        }

        rmdir(self::dir());
    }
}
