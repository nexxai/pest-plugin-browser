<?php

declare(strict_types=1);

namespace Pest\Browser\Support;

use Pest\Browser\Enums\Impact;

final class AccessibilityFormatter
{
    public static function format(array $data, Impact $impact): string
    {
        foreach ($data as $violation) {
            if (! is_array($violation)) {
                continue;
            }

            $violationImpact = $violation['impact'] ?? null;
            $violationRank = is_string($violationImpact) ? Impact::from($violationImpact)->rank() : -1;
            if ($violationRank >= $impact->rank()) {
                $violations[] = $violation;
            }
        }

        $lines = ['aXe issues'];

        foreach ($violations as $v) {
            $impactStr = isset($v['impact']) && is_string($v['impact']) ? $v['impact'] : 'unknown';
            $help = isset($v['help']) && is_string($v['help']) ? $v['help'] : '';
            $helpUrl = isset($v['helpUrl']) && is_string($v['helpUrl']) ? $v['helpUrl'] : '';
            $header = sprintf('- [%s] %s %s', $impactStr, $help, $helpUrl);
            $lines[] = $header;

            $nodes = isset($v['nodes']) && is_array($v['nodes']) ? $v['nodes'] : [];
            foreach ($nodes as $node) {
                if (! is_array($node)) {
                    continue;
                }

                $selector = '';
                if (isset($node['target'])) {
                    $targets = $node['target'];
                    if (is_array($targets)) {
                        $selector = implode(' ', array_values(array_filter(array_map(static fn ($t): string => is_string($t) ? $t : '', $targets), static fn (string $s): bool => $s !== '')));
                    } elseif (is_string($targets)) {
                        $selector = $targets;
                    }
                }
                if ($selector !== '') {
                    $lines[] = "  Selector: {$selector}";
                }

                $html = $node['html'] ?? null;
                if (is_string($html) && $html !== '') {
                    $lines[] = "  HTML: {$html}";
                }

                // any/none messages
                foreach (['any' => '  any:', 'none' => '  none:'] as $key => $label) {
                    $checks = isset($node[$key]) && is_array($node[$key]) ? $node[$key] : [];
                    $messages = [];
                    foreach ($checks as $check) {
                        if (is_array($check) && isset($check['message']) && is_string($check['message']) && $check['message'] !== '') {
                            $messages[] = $check['message'];
                        }
                    }
                    if ($messages !== []) {
                        $lines[] = $label;
                        foreach ($messages as $m) {
                            $lines[] = "    - {$m}";
                        }
                    }
                }

                // related nodes (from both any and none)
                $relatedNodes = [];
                foreach (['any', 'none'] as $k) {
                    $checks = isset($node[$k]) && is_array($node[$k]) ? $node[$k] : [];
                    foreach ($checks as $check) {
                        if (! is_array($check)) {
                            continue;
                        }
                        $rels = $check['relatedNodes'] ?? [];
                        if (is_array($rels)) {
                            foreach ($rels as $rel) {
                                if (is_array($rel)) {
                                    $relatedNodes[] = $rel;
                                }
                            }
                        }
                    }
                }

                if ($relatedNodes !== []) {
                    $lines[] = '  Related nodes:';
                    foreach ($relatedNodes as $relatedNode) {
                        $relSelector = '';
                        if (isset($relatedNode['target'])) {
                            $targets = $relatedNode['target'];
                            if (is_array($targets)) {
                                $relSelector = implode(' ', array_values(array_filter(array_map(static fn ($t): string => is_string($t) ? $t : '', $targets), static fn (string $s): bool => $s !== '')));
                            } elseif (is_string($targets)) {
                                $relSelector = $targets;
                            }
                        }
                        if ($relSelector !== '') {
                            $lines[] = "    Selector: {$relSelector}";
                        }
                        $relHtml = $relatedNode['html'] ?? null;
                        if (is_string($relHtml) && $relHtml !== '') {
                            $lines[] = "    HTML: {$relHtml}";
                        }
                    }
                }
            }
        }

        return implode(PHP_EOL, $lines);
    }
}
