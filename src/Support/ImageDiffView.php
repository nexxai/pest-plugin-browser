<?php

declare(strict_types=1);

namespace Pest\Browser\Support;

final class ImageDiffView
{
    public static function generate(string $expected, string $actual, string $diff, string $title): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>$title</title>
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
        </head>
        <body>
        <div x-data="{ activeTab: 'diff' }">
            <div class="tabs">
                <button @click="activeTab = 'diff'" :class="{ 'active': activeTab === 'diff' }">Diff</button>
                <button @click="activeTab = 'silder'" :class="{ 'active': activeTab === 'silder' }">Slider</button>
            </div>
            <div x-show="activeTab === 'diff'">
                <img alt="Diff" src="data:image/png;base64,$diff"/>
            </div>
            <div x-show="activeTab === 'silder'">
                <image-compare>
                    <img slot="image-1" alt="Expected" src="data:image/png;base64,$expected"/>
                    <img slot="image-2" alt="Actual" src="data:image/png;base64,$actual"/>
                </image-compare>
            </div>
            <script src="https://unpkg.com/@cloudfour/image-compare/dist/index.min.js"></script>
        </body>
        </html>
        HTML;
    }
}
