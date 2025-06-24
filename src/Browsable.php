<?php

declare(strict_types=1);

namespace Pest\Browser;

use Illuminate\Routing\UrlGenerator;
use Pest\Browser\Playwright\Client;
use Pest\Browser\Playwright\Page;

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
    public function visit(string $url, array $options = []): Page
    {
        return $this->page($url, $options);
    }

    /**
     * Browse to the given URL.
     *
     * @param  string|null  $url  The URL to visit, or null to start a new page without navigating.
     * @param  array<string, mixed>  $options  Options for the page, e.g. ['hasTouch' => true]
     */
    public function page(?string $url = null, array $options = []): Page
    {
        return page($url, $options);
    }
}
