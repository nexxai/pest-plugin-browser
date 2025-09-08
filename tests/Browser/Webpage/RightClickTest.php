<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

it('can right click an element', function (): void {
    Route::get('/', fn (): string => '
        <div id="result"></div>
        <button id="test-button" oncontextmenu="document.getElementById(\'result\').textContent = \'Right clicked\'; return false;">
            Right Click Me
        </button>
    ');

    $page = visit('/');

    $page->rightClick('#test-button');

    expect($page->text('#result'))->toBe('Right clicked');
});

it('can right click with text selector', function (): void {
    Route::get('/', fn (): string => '
        <div id="result"></div>
        <div oncontextmenu="document.getElementById(\'result\').textContent = \'Text right clicked\'; return false;">
            Click me with right button
        </div>
    ');

    $page = visit('/');

    $page->rightClick('Click me with right button');

    expect($page->text('#result'))->toBe('Text right clicked');
});

it('can right click with custom options', function (): void {
    Route::get('/', fn (): string => '
        <div id="result"></div>
        <div id="target" oncontextmenu="
            document.getElementById(\'result\').textContent = \'Right clicked with options\';
            return false;
        " style="width: 100px; height: 100px; background: red;">
            Target
        </div>
    ');

    $page = visit('/');

    $page->rightClick('#target', ['force' => true]);

    expect($page->text('#result'))->toBe('Right clicked with options');
});

it('can right click at specific position', function (): void {
    Route::get('/', fn (): string => '
        <div id="result"></div>
        <div id="target" oncontextmenu="
            document.getElementById(\'result\').textContent = \'Position right clicked\';
            return false;
        " style="width: 100px; height: 100px; background: blue;">
            Target
        </div>
    ');

    $page = visit('/');
    $page->rightClick('#target', ['position' => ['x' => 50, 'y' => 25]]);
    expect($page->text('#result'))->toBe('Position right clicked');
});

it('can right click on different element types', function (string $element): void {
    Route::get('/', fn (): string => "
        <div id=\"result\"></div>
        {$element}
    ");

    $page = visit('/');

    $page->rightClick('#test-element');

    expect($page->text('#result'))->toBe('Right clicked');
})->with([
    '<button id="test-element" oncontextmenu="document.getElementById(\'result\').textContent = \'Right clicked\'; return false;">Button</button>',
    '<div id="test-element" oncontextmenu="document.getElementById(\'result\').textContent = \'Right clicked\'; return false;">Div</div>',
    '<span id="test-element" oncontextmenu="document.getElementById(\'result\').textContent = \'Right clicked\'; return false;">Span</span>',
    '<a href="#" id="test-element" oncontextmenu="document.getElementById(\'result\').textContent = \'Right clicked\'; return false;">Link</a>',
]);

it('can assert context menu visibility', function (): void {
    Route::get('/', fn (): string => '
        <div id="target" oncontextmenu="
            const menu = document.getElementById(\'context-menu\');
            menu.style.display = \'block\';
            return false;
        ">Right click me</div>
        <div id="context-menu" role="menu" style="display: none; position: absolute; background: white; border: 1px solid black;">
            <div role="menuitem">Copy</div>
            <div role="menuitem">Paste</div>
            <div role="menuitem">Delete</div>
        </div>
    ');

    $page = visit('/');

    $page->assertMissing('#context-menu');
    $page->rightClick('#target');
    $page->assertVisible('#context-menu');
});

it('can assert context menu has specific options', function (): void {
    Route::get('/', fn (): string => '
        <div id="target" oncontextmenu="
            const menu = document.getElementById(\'context-menu\');
            menu.style.display = \'block\';
            return false;
        ">Right click me</div>
        <div id="context-menu" role="menu" style="display: none; position: absolute; background: white; border: 1px solid black;">
            <div role="menuitem">Copy</div>
            <div role="menuitem">Paste</div>
            <div role="menuitem">Delete</div>
            <div role="menuitem">Properties</div>
        </div>
    ');

    $page = visit('/');

    $page->assertMissing('#context-menu');
    $page->rightClick('#target');
    $page->assertVisible('#context-menu');
});

it('can handle right click with custom event handlers', function (): void {
    Route::get('/', fn (): string => '
        <div id="result"></div>
        <button id="custom-handler" oncontextmenu="
            document.getElementById(\'result\').textContent = \'Custom handler executed\';
            return false;
        ">
            Custom Right Click Handler
        </button>
    ');

    $page = visit('/');

    $page->rightClick('#custom-handler');

    expect($page->text('#result'))->toBe('Custom handler executed');
});

it('can right click elements within specific scope', function (): void {
    Route::get('/', fn (): string => '
        <div id="result"></div>
        <div id="container">
            <button oncontextmenu="document.getElementById(\'result\').textContent = \'Container button clicked\'; return false;">
                Click Me
            </button>
        </div>
        <div id="other-container">
            <button oncontextmenu="document.getElementById(\'result\').textContent = \'Other button clicked\'; return false;">
                Click Me
            </button>
        </div>
    ');

    $page = visit('/');

    $page->within('#container', function ($page): void {
        $page->rightClick('Click Me');
    });

    expect($page->text('#result'))->toBe('Container button clicked');
});
