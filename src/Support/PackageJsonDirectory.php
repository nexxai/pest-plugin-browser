<?php

declare(strict_types=1);

namespace Pest\Browser\Support;

use Pest\Browser\Exceptions\PlaywrightNotInstalledException;
use Pest\TestSuite;

/**
 * @internal
 */
final readonly class PackageJsonDirectory
{
    /**
     * The path to the npm "base" directory.
     */
    public static function find(): string
    {
        $rootPath = TestSuite::getInstance()->rootPath;

        $packageJsonPath = $rootPath.'/package.json';

        if (! file_exists($packageJsonPath)) {
            throw new PlaywrightNotInstalledException();
        }

        return dirname($packageJsonPath);
    }
}
