<?php

declare(strict_types=1);

namespace Pest\Browser\Exceptions;

use Pest\Browser\Playwright\Page;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @internal
 */
final class BrowserExpectationFailedException
{
    /**
     * Creates a new browser expectation failed exception instance.
     */
    public static function from(Page $page, ExpectationFailedException $e): ExpectationFailedException
    {
        $message = $e->getMessage();

        $consoleLogs = $page->consoleLogs();

        if (count($consoleLogs) > 0) {
            $message .= "\n\nThe following console logs were found:\n".implode("\n", array_map(
                fn (array $error): string => $error['message'],
                $consoleLogs,
            ));
        }

        $javaScriptErrors = $page->javaScriptErrors();

        if (count($javaScriptErrors) > 0) {
            $message .= "\n\nThe following JavaScript errors were found:\n".implode("\n", array_map(
                fn (array $error): string => $error['message'],
                $javaScriptErrors,
            ));
        }

        $filename = $page->screenshot();

        if ($filename !== null) {
            $message .= "\n\nA screenshot of the page has been saved to: $filename";
        }

        return new ExpectationFailedException(
            $message,
            $e->getComparisonFailure(),
            $e->getPrevious(), // @phpstan-ignore-line
        );
    }
}
