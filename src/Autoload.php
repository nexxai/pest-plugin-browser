<?php

declare(strict_types=1);

use Pest\Browser\Browser;
use Pest\Browser\Playwright\Client;
use Pest\Browser\Playwright\Page;
use Pest\Browser\Playwright\Playwright;
use Pest\Browser\ServerManager;
use Pest\Plugin;

Plugin::uses(Browser::class);

if (! function_exists('\Pest\Browser\page')) {
    /**
     * Visits the given URL, and starts a new browser test.
     *
     * @param  string|null  $url  The URL to visit
     * @param  array<string, mixed>  $options  Options for the page, e.g. ['hasTouch' => true]
     */
    function page(?string $url = null, array $options = []): Page
    {
        ServerManager::instance()->http()->start();

        Client::instance()->connectTo(
            ServerManager::instance()->playwright()->url().'?browser=chromium',
        );

        $browser = Playwright::chromium()->launch();
        $page = $browser->newContext($options)->newPage();

        if ($url !== null) {
            $page->goto($url);
        }

        return $page;
    }
}
