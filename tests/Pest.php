<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Playwright;
use Tests\TestCase;

pest()->uses(TestCase::class);

Playwright::setTimeout(2000);
