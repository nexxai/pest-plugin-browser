<?php

declare(strict_types=1);

namespace Pest\Browser\Enums;

enum Impact: string
{
    case Critical = 'critical';
    case Serious = 'serious';
    case Moderate = 'moderate';
    case Minor = 'minor';

    public function rank(): int
    {
        return match ($this) {
            Impact::Critical => 4,
            Impact::Serious => 3,
            Impact::Moderate => 2,
            Impact::Minor => 1,
        };
    }
}
