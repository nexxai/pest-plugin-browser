<?php

declare(strict_types=1);

namespace Pest\Browser\Api\Concerns;

use Pest\Browser\Api\Webpage;

/**
 * @mixin Webpage
 */
trait MakesConsoleAssertions
{
    /**
     * Asserts there are no console logs or JavaScript errors on the page.
     */
    public function assertNoSmoke(): Webpage
    {
        $this->assertNoConsoleLogs();
        $this->assertNoJavaScriptErrors();

        return $this;
    }

    /**
     * Asserts there are no console logs on the page.
     */
    public function assertNoConsoleLogs(): Webpage
    {
        $consoleLogs = $this->page->consoleLogs();

        expect($consoleLogs)->toBeEmpty(sprintf(
            "Expected no console logs on the page initially with the url [{$this->initialUrl}], but found %s: %s",
            count($consoleLogs),
            implode(', ', array_map(fn (array $log) => $log['message'], $consoleLogs)),
        ));

        return $this;
    }

    /**
     * Asserts there are no JavaScript errors on the page.
     */
    public function assertNoJavaScriptErrors(): Webpage
    {
        $javaScriptErrors = $this->page->javaScriptErrors();

        expect($javaScriptErrors)->toBeEmpty(sprintf(
            "Expected no JavaScript errors on the page initially with the url [{$this->initialUrl}], but found %s: %s",
            count($javaScriptErrors),
            implode(', ', array_map(fn (array $log) => $log['message'], $javaScriptErrors)),
        ));

        return $this;
    }
}
