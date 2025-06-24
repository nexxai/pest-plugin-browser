<?php

declare(strict_types=1);

namespace Pest\Browser;

use Illuminate\Routing\UrlGenerator;
use Pest\Browser\Api\Webpage;
use Pest\Browser\Playwright\Client;
use Pest\Browser\Playwright\Playwright;

/**
 * @internal
 */
trait Browsable
{
    /**
     * Marks the test as a browser test.
     *
     * @internal
     */
    public function __markAsBrowserTest(): void
    {
        Client::instance()->connectTo(
            ServerManager::instance()->playwright()->url(),
        );

        ServerManager::instance()->http()->start();

        $url = ServerManager::instance()->http()->url();

        config(['app.url' => $url]);

        if (app()->bound('url')) {
            $urlGenerator = app('url');

            assert($urlGenerator instanceof UrlGenerator);

            $urlGenerator->useOrigin($url);
        }
    }

    /**
     * Browse to the given URL.
     *
     * @param  array<string, mixed>  $options
     */
    public function visit(?string $url = null, array $options = []): Webpage
    {
        $browser = Playwright::chromium()->launch();

        $page = $browser->newContext($options)->newPage();

        if ($url !== null) {
            $page->goto($url, $options);
        }

        return new Webpage($page);
    }
}
