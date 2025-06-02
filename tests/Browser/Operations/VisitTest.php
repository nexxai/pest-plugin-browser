<?php

declare(strict_types=1);

test('visit', function (): void {
    $this->visit('/')
        ->assertTitle('Pest Plugin Browser - Playground');
});
