<?php

declare(strict_types=1);

namespace Pest\Browser;

use Illuminate\Routing\UrlGenerator;
use Pest\Browser\Api\ArrayablePendingAwaitablePage;
use Pest\Browser\Api\PendingAwaitablePage;
use Pest\Browser\Enums\Device;
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

        $http = ServerManager::instance()->http();

        $http->start();

        $url = $http->url();

        config(['app.url' => $url]);

        config(['cors.paths' => ['*']]);

        if (app()->bound('url')) {
            $urlGenerator = app('url');

            assert($urlGenerator instanceof UrlGenerator);

            $http->setOriginalAssetUrl($urlGenerator->asset(''));

            $urlGenerator->useOrigin($url);
            $urlGenerator->useAssetOrigin($url);
            $urlGenerator->forceScheme('http');
        }
    }

    /**
     * Browse to the given URL.
     *
     * @param  array<int, string>|string  $url
     * @param  array<string, mixed>  $options
     */
    public function visit(array|string $url, array $options = []): ArrayablePendingAwaitablePage|PendingAwaitablePage
    {
        if (is_string($url)) {
            return new PendingAwaitablePage(
                Playwright::defaultBrowserType(),
                Device::DESKTOP,
                $url,
                $options,
            );
        }

        return new ArrayablePendingAwaitablePage(
            array_map(fn (string $singleUrl): PendingAwaitablePage => new PendingAwaitablePage(
                Playwright::defaultBrowserType(),
                Device::DESKTOP,
                $singleUrl,
                $options,
            ), $url),
        );
    }
}
