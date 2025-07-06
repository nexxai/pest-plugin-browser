<?php

declare(strict_types=1);

namespace Pest\Browser\Exceptions;

use NunoMaduro\Collision\Contracts\RenderlessEditor;
use RuntimeException;

/**
 * @internal
 */
final class DebugNotAvailableException extends RuntimeException implements RenderlessEditor
{
    //
}
