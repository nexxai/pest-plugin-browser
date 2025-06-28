<?php

declare(strict_types=1);

namespace Pest\Browser\Exceptions;

use PHPUnit\Framework\ExpectationFailedException;

/**
 * @internal
 */
final class BrowserExpectationFailedException
{
    /**
     * Creates a new browser expectation failed exception instance.
     *
     * @param  array<int, mixed>  $arguments
     */
    public static function from(ExpectationFailedException $e, string $methodName, array $arguments): ExpectationFailedException
    {
        $message = $e->getMessage();

        $message = match (true) {
            preg_match('/^Timeout \d+ms exceeded.$/', $message) === 1 => self::humanizeMethodName($methodName, $arguments),
            default => $message,
        };

        return new ExpectationFailedException(
            $message,
            $e->getComparisonFailure(),
            $e->getPrevious(), // @phpstan-ignore-line
        );
    }

    /**
     * Creates a human-readable method name based on the method and its arguments.
     *
     * @param  array<int, mixed>  $arguments
     */
    private static function humanizeMethodName(string $methodName, array $arguments): string
    {
        $methodName = preg_replace('/([A-Z])/', ' $1', $methodName);
        $methodName = mb_strtolower((string) $methodName);
        $methodName = str_starts_with($methodName, 'assert') ? 'Failed to '.$methodName : 'Failed to fetch '.$methodName;

        if (count($arguments) > 0) {
            return $methodName;
        }

        return $methodName.' with arguments ['.self::humanizeArguments($arguments).']';
    }

    /**
     * Converts the arguments to a human-readable string.
     *
     * @param  array<int, mixed>  $arguments
     */
    private static function humanizeArguments(array $arguments): string
    {
        return implode(', ', array_map(
            // @phpstan-ignore-next-line
            fn (mixed $arg): string|false => is_array($arg) ? json_encode($arg, JSON_THROW_ON_ERROR) : (string) $arg,
            $arguments,
        ));
    }
}
