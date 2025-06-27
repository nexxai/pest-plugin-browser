<?php

declare(strict_types=1);

namespace Pest\Browser\Api;

use Pest\Browser\Enums\ColorScheme;
use Pest\Browser\Enums\Device;
use Pest\Browser\Playwright\InitScript;
use Pest\Browser\Playwright\Playwright;

/**
 * @mixin Webpage
 */
final class PendingAwaitablePage
{
    /**
     * The webpage instance that will be returned when the page is visited.
     */
    private ?AwaitableWebpage $waitablePage = null;

    /**
     * Creates a new pending awaitable page instance.
     *
     * @param  array<string, mixed>  $options
     */
    public function __construct(
        private readonly Device $device = Device::DESKTOP,
        private readonly ?string $url = null,
        private readonly array $options = [],
    ) {
        //
    }

    /**
     * Creates the actual visit page instance, and calls the given method on it.
     *
     * @param  array<int, mixed>  $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        $this->waitablePage ??= $this->createAwaitablePage();

        // @phpstan-ignore-next-line
        return $this->waitablePage->{$name}(...$arguments);
    }

    /**
     * Sets the color scheme to dark mode.
     */
    public function inDarkMode(): self
    {
        return new self($this->device, $this->url, [
            'colorScheme' => ColorScheme::DARK->value,
            ...$this->options,
        ]);
    }

    /**
     * Sets the color scheme to light mode.
     */
    public function inLightMode(): self
    {
        return new self($this->device, $this->url, [
            'colorScheme' => ColorScheme::LIGHT->value,
            ...$this->options,
        ]);
    }

    /**
     * Sets the device to desktop.
     */
    public function onDesktop(): self
    {
        return new self(Device::DESKTOP, $this->url, $this->options);
    }

    /**
     * Sets the device to mobile.
     */
    public function onMobile(): self
    {
        return new self(Device::MOBILE, $this->url, $this->options);
    }

    /**
     * Sets the device to MacBook 16".
     */
    public function onMacbook16(): self
    {
        return new self(Device::MACBOOK_16, $this->url, $this->options);
    }

    /**
     * Sets the device to MacBook 14".
     */
    public function onMacbook14(): self
    {
        return new self(Device::MACBOOK_14, $this->url, $this->options);
    }

    /**
     * Sets the device to MacBook Air.
     */
    public function onMacbookAir(): self
    {
        return new self(Device::MACBOOK_AIR, $this->url, $this->options);
    }

    /**
     * Sets the device to iPhone 15 Pro.
     */
    public function oniPhone15Pro(): self
    {
        return new self(Device::IPHONE_15_PRO, $this->url, $this->options);
    }

    /**
     * Sets the device to iPhone 15.
     */
    public function oniPhone15(): self
    {
        return new self(Device::IPHONE_15, $this->url, $this->options);
    }

    /**
     * Sets the device to iPhone 14 Pro.
     */
    public function oniPhone14Pro(): self
    {
        return new self(Device::IPHONE_14_PRO, $this->url, $this->options);
    }

    /**
     * Sets the device to iPhone SE.
     */
    public function oniPhoneSE(): self
    {
        return new self(Device::IPHONE_SE, $this->url, $this->options);
    }

    /**
     * Sets the device to iPad Pro.
     */
    public function oniPadPro(): self
    {
        return new self(Device::IPAD_PRO, $this->url, $this->options);
    }

    /**
     * Sets the device to iPad Mini.
     */
    public function oniPadMini(): self
    {
        return new self(Device::IPAD_MINI, $this->url, $this->options);
    }

    /**
     * Sets the device to Pixel 8.
     */
    public function onPixel8(): self
    {
        return new self(Device::PIXEL_8, $this->url, $this->options);
    }

    /**
     * Sets the device to Pixel 7.
     */
    public function onPixel7(): self
    {
        return new self(Device::PIXEL_7, $this->url, $this->options);
    }

    /**
     * Sets the device to Pixel 6a.
     */
    public function onPixel6a(): self
    {
        return new self(Device::PIXEL_6A, $this->url, $this->options);
    }

    /**
     * Sets the device to Galaxy S24 Ultra.
     */
    public function onGalaxyS24Ultra(): self
    {
        return new self(Device::GALAXY_S24_ULTRA, $this->url, $this->options);
    }

    /**
     * Sets the device to Galaxy S23.
     */
    public function onGalaxyS23(): self
    {
        return new self(Device::GALAXY_S23, $this->url, $this->options);
    }

    /**
     * Sets the device to Galaxy S22.
     */
    public function onGalaxyS22(): self
    {
        return new self(Device::GALAXY_S22, $this->url, $this->options);
    }

    /**
     * Sets the device to Galaxy Note 20.
     */
    public function onGalaxyNote20(): self
    {
        return new self(Device::GALAXY_NOTE_20, $this->url, $this->options);
    }

    /**
     * Sets the device to Galaxy Tab S8.
     */
    public function onGalaxyTabS8(): self
    {
        return new self(Device::GALAXY_TAB_S8, $this->url, $this->options);
    }

    /**
     * Sets the device to Surface Pro 9.
     */
    public function onSurfacePro9(): self
    {
        return new self(Device::SURFACE_PRO_9, $this->url, $this->options);
    }

    /**
     * Sets the device to Surface Laptop 5.
     */
    public function onSurfaceLaptop5(): self
    {
        return new self(Device::SURFACE_LAPTOP_5, $this->url, $this->options);
    }

    /**
     * Sets the device to OnePlus 11.
     */
    public function onOneplus11(): self
    {
        return new self(Device::ONEPLUS_11, $this->url, $this->options);
    }

    /**
     * Sets the device to Xiaomi 13.
     */
    public function onXiaomi13(): self
    {
        return new self(Device::XIAOMI_13, $this->url, $this->options);
    }

    /**
     * Sets the device to Huawei P50.
     */
    public function onHuaweiP50(): self
    {
        return new self(Device::HUAWEI_P50, $this->url, $this->options);
    }

    /**
     * Creates the webpage instance.
     */
    private function createAwaitablePage(): AwaitableWebpage
    {
        $browser = Playwright::default()->launch();

        $context = $browser->newContext([
            'locale' => 'en-US',
            'timezoneId' => 'UTC',
            'colorScheme' => Playwright::defaultColorScheme()->value,
            ...$this->device->context(),
            ...$this->options,
        ]);

        $context->addInitScript(InitScript::get());

        $page = $context->newPage();

        if ($this->url !== null) {
            $page->goto($this->url, $this->options);
        }

        return new AwaitableWebpage($page);
    }
}
