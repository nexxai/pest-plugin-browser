<?php

declare(strict_types=1);

namespace Pest\Browser\Api\Concerns;

use Pest\Browser\Api\Webpage;
use Pest\Browser\Playwright\Playwright;

/**
 * @mixin Webpage
 */
trait MakesScreenshotAssertions
{
    /**
     * Asserts that the screenshot matches the expected image.
     */
    public function assertScreenshotMatches(bool $fullPage = true, ?bool $openDiff = null): self
    {
        $this->page->addStyleTag('* { transition: none !important; animation: none !important; }');
        $this->page->waitForLoadState('networkidle');

        $this->page->expectScreenshot(
            $fullPage,
            $openDiff ?? Playwright::shouldShowDiffOnScreenshotAssertions(),
        );

        return $this;
    }
}
