<?php

declare(strict_types=1);

namespace Pest\Browser\Exceptions;

use Pest\Browser\Playwright\Page;
use Pest\Browser\Playwright\Playwright;
use Pest\Browser\ServerManager;
use PHPUnit\Framework\ExpectationFailedException;
use Throwable;

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

        if (Playwright::shouldDebugAssertions() === false) {
            $filename = $page->screenshot();

            if ($filename !== null) {
                $message .= " A screenshot of the page has been saved to [Tests/Browser/Screenshots/$filename].";
            }
        }

        $consoleLogs = $page->consoleLogs();

        if (count($consoleLogs) > 0) {
            $message .= "\n\nThe following console logs were found:\n".implode("\n", array_map(
                fn (array $error): string => '- '.$error['message'],
                $consoleLogs,
            ));
        }

        $javaScriptErrors = $page->javaScriptErrors();

        if (count($javaScriptErrors) > 0) {
            $message .= "\n\nThe following JavaScript errors were found:\n".implode("\n", array_map(
                fn (array $error): string => '- '.$error['message'],
                $javaScriptErrors,
            ));
        }

        $httpThrowable = ServerManager::instance()->http()->lastThrowable();

        if ($httpThrowable instanceof Throwable) {
            $message .= "\n\nThe following HTTP error occurred:\n- ".$httpThrowable->getMessage();
        }

        return new ExpectationFailedException(
            $message,
            $e->getComparisonFailure(),
            $e->getPrevious(), // @phpstan-ignore-line
        );
    }
}
