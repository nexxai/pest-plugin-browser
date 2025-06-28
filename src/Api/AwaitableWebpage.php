<?php

declare(strict_types=1);

namespace Pest\Browser\Api;

use Pest\Browser\Exceptions\BrowserExpectationFailedException;
use Pest\Browser\Playwright\Page;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @mixin Webpage
 */
final readonly class AwaitableWebpage
{
    /**
     * Creates a new awaitable webpage instance.
     *
     * @param  array<int, string>  $nonAwaitableMethods
     */
    public function __construct(
        private Page $page,
        private array $nonAwaitableMethods = [
            'assertScreenshotMatches',
        ],
    ) {
        //
    }

    /**
     * Awaits for the given method to assert true or fail.
     *
     * @param  array<int, mixed>  $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        $webpage = new Webpage($this->page);

        if (in_array($name, $this->nonAwaitableMethods, true)) {
            // @phpstan-ignore-next-line
            return $webpage->{$name}(...$arguments);
        }

        try {
            $result = $this->page->await(
                // @phpstan-ignore-next-line
                fn () => $webpage->{$name}(...$arguments),
            );
        } catch (ExpectationFailedException $e) {
            $e = BrowserExpectationFailedException::from($e, $name, $arguments);

            throw $e;
        }

        return $result === $webpage
            ? $this
            : $result;
    }
}
