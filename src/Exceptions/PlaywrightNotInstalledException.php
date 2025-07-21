<?php

declare(strict_types=1);

namespace Pest\Browser\Exceptions;

use NunoMaduro\Collision\Contracts\RenderlessEditor;
use NunoMaduro\Collision\Contracts\RenderlessTrace;
use RuntimeException;

/**
 * @internal
 */
final class PlaywrightNotInstalledException extends RuntimeException implements RenderlessEditor, RenderlessTrace
{
    //
}
