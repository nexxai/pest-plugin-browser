<?php

declare(strict_types=1);

namespace Pest\Browser\Support;

use Pest\Browser\Playwright\Locator;
use Pest\Browser\Playwright\Page;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @internal
 */
final readonly class GuessLocator
{
    /**
     * Creates a new guess locator instance.
     */
    public function __construct(
        private Page $page,
        private ?string $scopeSelector = null,
    ) {
        //
    }

    /**
     * Guesses the locator for the given page and selector.
     */
    public function for(string $selector, ?string $value = null): Locator
    {
        if (Selector::isExplicit($selector)) {
            if ($value !== null) {
                $selector .= sprintf('[value=%s]', Selector::escapeForAttributeSelectorOrRegex($value, true));
            }

            return $this->page->locator($this->scopeSelector($selector));
        }

        if (Selector::isDataTest($selector)) {
            $id = Selector::escapeForAttributeSelectorOrRegex(str_replace('@', '', $selector), true);

            return $this->page->unstrict(
                fn (): Locator => $this->page->locator(
                    $this->scopeSelector("[data-testid=$id], [data-test=$id]"),
                ),
            );
        }

        foreach (['[id="%s"]', '[name="%s"]'] as $format) {
            $formattedSelector = sprintf($format, $selector);

            if ($value !== null) {
                $formattedSelector .= sprintf('[value=%s]', Selector::escapeForAttributeSelectorOrRegex($value, true));
            }

            $locator = $this->page->unstrict(
                fn (): Locator => $this->page->locator($this->scopeSelector($formattedSelector)),
            );

            if ($locator->count() > 0) {
                return $locator;
            }
        }

        if ($value !== null) {
            return throw new ExpectationFailedException(
                sprintf('Selector [%s] does not match any element.', $selector)
            );
        }

        if ($this->scopeSelector !== null) {
            $scopedLocator = $this->page->locator($this->scopeSelector);

            return $this->page->unstrict(
                fn (): Locator => $scopedLocator->getByText($selector, true),
            );
        }

        return $this->page->unstrict(
            fn (): Locator => $this->page->getByText($selector, true),
        );
    }

    private function scopeSelector(string $selector): string
    {
        if ($this->scopeSelector === null) {
            return $selector;
        }

        return $this->scopeSelector.' >> '.$selector;
    }
}
