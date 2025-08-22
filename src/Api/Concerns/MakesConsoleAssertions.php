<?php

declare(strict_types=1);

namespace Pest\Browser\Api\Concerns;

use Pest\Browser\Api\Webpage;
use Pest\Browser\Enums\Impact;
use Pest\Browser\Playwright\Page;
use Pest\Browser\Support\AccessibilityFormatter;

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

    /**
     * Asserts the accessibility of the page.
     */
    public function assertAccessibility(Impact $impact = Impact::Minor): Webpage
    {
        $violations = $this->page->evaluate('window.__pestBrowser.accessibilityViolations || []');
        if (! is_array($violations)) {
            $violations = [];
        }

        $report = AccessibilityFormatter::format($violations, $impact);

        expect($violations)->toBeEmpty($report);

        return $this;
    }
}
