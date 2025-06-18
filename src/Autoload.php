<?php

declare(strict_types=1);

use Pest\Browser\Browser;
use Pest\Browser\Drivers\Laravel\Autoload;
use Pest\Browser\Playwright\Page;
use Pest\Browser\Playwright\Playwright;
use Pest\Plugin;

Plugin::uses(Browser::class);

if (! function_exists('\Pest\Browser\page')) {
    /**
     * Visits the given URL, and starts a new browser test.
     *
     * @param  string|null  $url  The URL to visit
     * @param  array<string, mixed>  $options  Options for the page or for the goto, e.g. ['hasTouch' => true]
     */
    function page(?string $url = null, array $options = []): Page
    {
        $browser = Playwright::chromium()->launch();
        $page = $browser->newContext($options)->newPage();

        if ($url !== null) {
            $page->goto($url, $options);
        }

        return $page;
    }
}

Autoload::boot();
