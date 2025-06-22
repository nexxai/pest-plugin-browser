<?php

declare(strict_types=1);

return;

arch('src')
    ->expect('Pest\Browser')
    ->toHaveMethodsDocumented()
    ->toHavePropertiesDocumented();

arch()->preset()->php()->ignoring([
    'App',
    'Tests',
]);
arch()->preset()->strict()->ignoring([
    'App',
    'Tests',
]);
arch()->preset()->security()->ignoring([
    'App',
    'Tests',
    'assert',
    'uniqid',
    'rand',
    'eval',
]);
