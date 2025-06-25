<?php

declare(strict_types=1);

namespace Pest\Browser\Api;

use Pest\Browser\Playwright\Locator;
use Pest\Browser\Playwright\Page;
use Pest\Browser\Support\GuessLocator;

final readonly class Webpage
{
    use Concerns\InteractsWithElements,
        Concerns\MakesAssertions,
        Concerns\MakesUrlAssertions,
        Concerns\WaitsForElements;

    /**
     * The page instance.
     */
    public function __construct(
        private Page $page,
    ) {
        //
    }

    /**
     * Dumps the current page's content and stops the execution.
     */
    public function dd(): never
    {
        dd($this->page->content());
    }

    /**
     * Gets the page's content.
     */
    public function content(): string
    {
        return $this->page->content();
    }

    /**
     * Gets the page's URL.
     */
    public function url(): string
    {
        return $this->page->url();
    }

    /**
     * Executes a script in the context of the page.
     */
    public function script(string $content): mixed
    {
        return $this->page->evaluate($content);
    }

    /**
     * Gets the page instance.
     */
    public function value(string $selector): string
    {
        return $this->guessLocator($selector)->inputValue();
    }

    /**
     * Gets the locator for the given selector.
     */
    private function guessLocator(string $selector, ?string $value = null): Locator
    {
        return (new GuessLocator($this->page))->for($selector, $value);
    }
}
