<?php

declare(strict_types=1);

namespace Pest\Browser\Api\Concerns;

use Pest\Browser\Api\Webpage;
use Pest\Browser\Enums\Impact;
use Pest\Browser\Support\AccessibilityFormatter;

/**
 * @mixin Webpage
 * @phpstan-import-type Violations from AccessibilityFormatter
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
        /** @var Violations|null $violations */
        $violations = $this->page->evaluate('async () => ((await window.axe.run()).violations)');
        if (! is_array($violations)) {
            $violations = [];
        }

        $violations = array_filter($violations, function ($violation) use ($impact): bool {
            $violationImpact = $violation['impact'] ?? null;
            $violationRank = is_string($violationImpact) ? Impact::from($violationImpact)->rank() : -1;

            return $violationRank >= $impact->rank();
        });

        $report = AccessibilityFormatter::format($violations);

        expect($violations)->toBeEmpty($report);

        return $this;
    }
}
