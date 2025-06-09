<?php

declare(strict_types=1);

it('hovers over elements and verifies hover state changes', function (): void {
    $page = $this->page()->goto('/test/element-tests');

    $hoverTargetLocator = $page->getByTestId('hover-target');
    $hoverTarget = $hoverTargetLocator->elementHandle();

    $hoverDisplayLocator = $page->getByTestId('hover-display');
    $hoverDisplay = $hoverDisplayLocator->elementHandle();

    expect($hoverDisplay->textContent())->toBe('No element hovered yet');

    $hoverTarget->hover();

    expect($hoverDisplay->textContent())->toBe('Last hovered: hover-target');
    expect($hoverTarget->isVisible())->toBeTrue();
});
