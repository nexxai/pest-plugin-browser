<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright\Concerns;

use Illuminate\Support\Str;
use Pest\Browser\Playwright\Page;

/**
 * @mixin Page
 */
trait MakesAssertions
{
    /**
     * Assert that the page title matches the given text.
     */
    public function assertTitle(string $title): Page
    {
        expect($this->title())->toBe($title, "Expected page title to be '{$title}' but found '{$this->title()}'.");

        return $this;
    }

    /**
     * Assert that the page title contains the given text.
     */
    public function assertTitleContains(string $title): Page
    {
        $pageTitle = $this->title();
        $message = "Expected page title to contain '{$title}' but found '{$pageTitle}'.";
        expect(str_contains($pageTitle, $title))->toBeTrue($message);

        return $this;
    }

    /**
     * Assert that the given text is present on the page.
     */
    public function assertSee(string $text): Page
    {
        expect($this->getByText($text)->isVisible())->toBeTrue("Expected to see text '{$text}' on the page, but it was not found or not visible.");

        return $this;
    }

    /**
     * Assert that the given text is not present on the page.
     */
    public function assertDontSee(string $text): Page
    {
        expect($this->getByText($text)->count())->toBe(0, "Expected not to see text '{$text}' on the page, but it was found.");

        return $this;
    }

    /**
     * Assert that the given text is present within the selector.
     */
    public function assertSeeIn(string $selector, string $text): Page
    {
        $locator = $this->locator($selector);

        expect($locator->getByText($text)->isVisible())->toBeTrue("Expected to see text '{$text}' within element '{$selector}', but it was not found or not visible.");

        return $this;
    }

    /**
     * Assert that the given text is not present within the selector.
     */
    public function assertDontSeeIn(string $selector, string $text): Page
    {
        $locator = $this->locator($selector);

        expect($locator->getByText($text)->count())->toBe(0, "Expected not to see text '{$text}' within element '{$selector}', but it was found.");

        return $this;
    }

    /**
     * Assert that any text is present within the selector.
     */
    public function assertSeeAnythingIn(string $selector): Page
    {
        $text = $this->locator($selector)->textContent();

        expect($text)->not->toBeEmpty("Expected element '{$selector}' to contain some text, but it was empty.");

        return $this;
    }

    /**
     * Assert that no text is present within the selector.
     */
    public function assertSeeNothingIn(string $selector): Page
    {
        $text = $this->locator($selector)->textContent();

        expect($text)->toBeEmpty("Expected element '{$selector}' to be empty, but it contained text: '{$text}'.");

        return $this;
    }

    /**
     * Assert that a given element is present a given amount of times.
     */
    public function assertCount(string $selector, int $expected): Page
    {
        $count = $this->locator($selector)->count();
        expect($count)->toBe($expected, "Expected to find {$expected} elements matching '{$selector}', but found {$count}.");

        return $this;
    }

    /**
     * Assert that the given JavaScript expression evaluates to the given value.
     */
    public function assertScript(string $expression, mixed $expected = true): Page
    {
        // For simple expressions without comparison operators, we'll create a function that returns the value
        // This avoids issues with adding 'return' statements directly to expressions
        if (! Str::contains($expression, ['===', '!==', '==', '!=', '>', '<', '>=', '<=', '&&', '||']) && ! Str::startsWith($expression, 'return ') && ! Str::startsWith($expression, 'function')) {
            $expression = "function() { return {$expression}; }";
        }

        $result = $this->evaluate($expression);
        $expectedStr = is_bool($expected) ? ($expected ? 'true' : 'false') : (is_string($expected) ? "'{$expected}'" : (string) $expected);
        $resultStr = is_bool($result) ? ($result ? 'true' : 'false') : (is_string($result) ? "'{$result}'" : (string) $result);

        expect($result)->toBe($expected, "Expected JavaScript expression '{$expression}' to evaluate to {$expectedStr}, but got {$resultStr}.");

        return $this;
    }

    /**
     * Assert that the given source code is present on the page.
     */
    public function assertSourceHas(string $code): Page
    {
        $content = $this->content();
        $message = "Expected page source to contain '{$code}', but it was not found.";
        expect(str_contains($content, $code))->toBeTrue($message);

        return $this;
    }

    /**
     * Assert that the given source code is not present on the page.
     */
    public function assertSourceMissing(string $code): Page
    {
        $content = $this->content();
        $message = "Expected page source not to contain '{$code}', but it was found.";
        expect(str_contains($content, $code))->toBeFalse($message);

        return $this;
    }

    /**
     * Assert that the given link is present on the page.
     */
    public function assertSeeLink(string $link): Page
    {
        $locator = $this->locator("a:has-text('{$link}')");

        expect($locator->isVisible())->toBeTrue("Expected to see link with text '{$link}', but it was not found or not visible.");

        return $this;
    }

    /**
     * Assert that the given link is not present on the page.
     */
    public function assertDontSeeLink(string $link): Page
    {
        $locator = $this->locator("a:has-text('{$link}')");

        expect($locator->count())->toBe(0, "Expected not to see link with text '{$link}', but it was found.");

        return $this;
    }

    /**
     * Assert that the given input field has the given value.
     */
    public function assertInputValue(string $field, string $value): Page
    {
        $locator = $this->locatorForTyping($field);
        $actual = $locator->inputValue();

        expect($actual)->toBe($value, "Expected input field '{$field}' to have value '{$value}', but found '{$actual}'.");

        return $this;
    }

    /**
     * Assert that the given input field does not have the given value.
     */
    public function assertInputValueIsNot(string $field, string $value): Page
    {
        $locator = $this->locatorForTyping($field);
        $actual = $locator->inputValue();

        expect($actual)->not->toBe($value, "Expected input field '{$field}' not to have value '{$value}', but it did.");

        return $this;
    }

    /**
     * Assert that the given input field is present.
     */
    public function assertInputPresent(string $field): Page
    {
        $locator = $this->locatorForTyping($field);
        $count = $locator->count();

        expect($count)->toBeGreaterThan(0, "Expected input field '{$field}' to be present, but it was not found.");

        return $this;
    }

    /**
     * Assert that the given input field is not visible.
     */
    public function assertInputMissing(string $field): Page
    {
        $locator = $this->locatorForTyping($field);
        $count = $locator->count();

        expect($count)->toBe(0, "Expected input field '{$field}' to be missing, but it was found.");

        return $this;
    }

    /**
     * Assert that the given checkbox is checked.
     */
    public function assertChecked(string $field, ?string $value = null): Page
    {
        $valueDescription = $value !== null ? " with value '{$value}'" : '';
        expect($this->locatorForChecking($field, $value)->isChecked())->toBeTrue("Expected checkbox '{$field}'{$valueDescription} to be checked, but it was not.");

        return $this;
    }

    /**
     * Assert that the given checkbox is not checked.
     */
    public function assertNotChecked(string $field, ?string $value = null): Page
    {
        $valueDescription = $value !== null ? " with value '{$value}'" : '';
        expect($this->locatorForChecking($field, $value)->isChecked())->toBeFalse("Expected checkbox '{$field}'{$valueDescription} not to be checked, but it was.");

        return $this;
    }

    /**
     * Assert that the given checkbox is in an indeterminate state.
     */
    public function assertIndeterminate(string $field, ?string $value = null): Page
    {
        $this->assertNotChecked($field, $value);

        $selector = $this->locatorForChecking($field, $value)->selector();
        $escapedSelector = json_encode($selector);

        $isIndeterminate = $this->evaluate("
            () => {
                const element = document.querySelector({$escapedSelector});
                return element ? element.indeterminate === true : false;
            }
        ");

        $valueDescription = $value !== null ? " with value '{$value}'" : '';
        expect($isIndeterminate)->toBeTrue("Expected checkbox '{$field}'{$valueDescription} to be in indeterminate state, but it was not.");

        return $this;
    }

    /**
     * Assert that the given radio field is selected.
     */
    public function assertRadioSelected(string $field, string $value): Page
    {
        expect($this->locatorForRadioSelection($field, $value)->isChecked())->toBeTrue("Expected radio button '{$field}' with value '{$value}' to be selected, but it was not.");

        return $this;
    }

    /**
     * Assert that the given radio field is not selected.
     */
    public function assertRadioNotSelected(string $field, ?string $value = null): Page
    {
        if ($value !== null) {
            expect($this->locatorForRadioSelection($field, $value)->isChecked())->toBeFalse("Expected radio button '{$field}' with value '{$value}' not to be selected, but it was.");
        } else {
            $selector = "input[type='radio'][name='{$field}']";
            $count = $this->locator($selector)->count();

            $anyChecked = false;
            for ($i = 0; $i < $count; $i++) {
                $radio = $this->locator($selector)->nth($i);
                if ($radio->isChecked()) {
                    $anyChecked = true;
                    break;
                }
            }

            expect($anyChecked)->toBeFalse("Expected no radio buttons in group '{$field}' to be selected, but at least one was selected.");
        }

        return $this;
    }

    /**
     * Assert that the given dropdown has the given value selected.
     */
    public function assertSelected(string $field, string $value): Page
    {
        $locator = $this->locatorForSelection($field);
        $actual = $locator->inputValue();

        expect($actual)->toBe($value, "Expected dropdown '{$field}' to have value '{$value}' selected, but found '{$actual}'.");

        return $this;
    }

    /**
     * Assert that the given dropdown does not have the given value selected.
     */
    public function assertNotSelected(string $field, string $value): Page
    {
        $locator = $this->locatorForSelection($field);
        $actual = $locator->inputValue();

        expect($actual)->not->toBe($value, "Expected dropdown '{$field}' not to have value '{$value}' selected, but it was.");

        return $this;
    }

    /**
     * Assert that the given array of values is available to be selected.
     *
     * @param  array<int, string>  $values
     */
    public function assertSelectHasOptions(string $field, array $values): Page
    {
        $options = $this->evaluate("
            () => {
                const select = document.querySelector('select[name=\"{$field}\"]') || document.getElementById('{$field}');
                return select ? Array.from(select.options).map(option => option.value) : [];
            }
        ");

        foreach ($values as $value) {
            $message = "Expected dropdown '{$field}' to have option with value '{$value}', but it was not found. Available options: ".implode(', ', $options);
            expect(in_array($value, $options))->toBeTrue($message);
        }

        return $this;
    }

    /**
     * Assert that the given array of values is not available to be selected.
     *
     * @param  array<int, string>  $values
     */
    public function assertSelectMissingOptions(string $field, array $values): Page
    {
        $options = $this->evaluate("
            () => {
                const select = document.querySelector('select[name=\"{$field}\"]') || document.getElementById('{$field}');
                return select ? Array.from(select.options).map(option => option.value) : [];
            }
        ");

        foreach ($values as $value) {
            $message = "Expected dropdown '{$field}' not to have option with value '{$value}', but it was found. Available options: ".implode(', ', $options);
            expect(in_array($value, $options))->toBeFalse($message);
        }

        return $this;
    }

    /**
     * Assert that the given value is available to be selected on the given field.
     */
    public function assertSelectHasOption(string $field, string $value): Page
    {
        return $this->assertSelectHasOptions($field, [$value]);
    }

    /**
     * Assert that the given value is not available to be selected.
     */
    public function assertSelectMissingOption(string $field, string $value): Page
    {
        return $this->assertSelectMissingOptions($field, [$value]);
    }

    /**
     * Assert that the element matching the given selector has the given value.
     */
    public function assertValue(string $selector, string $value): Page
    {
        $actual = $this->locator($selector)->inputValue();
        expect($actual)->toBe($value, "Expected element '{$selector}' to have value '{$value}', but found '{$actual}'.");

        return $this;
    }

    /**
     * Assert that the element matching the given selector does not have the given value.
     */
    public function assertValueIsNot(string $selector, string $value): Page
    {
        $actual = $this->locator($selector)->inputValue();
        expect($actual)->not->toBe($value, "Expected element '{$selector}' not to have value '{$value}', but it did.");

        return $this;
    }

    /**
     * Assert that the element matching the given selector has the given value in the provided attribute.
     */
    public function assertAttribute(string $selector, string $attribute, string $value): Page
    {
        $actual = $this->locator($selector)->getAttribute($attribute);
        expect($actual)->toBe($value, "Expected element '{$selector}' to have attribute '{$attribute}' with value '{$value}', but found '{$actual}'.");

        return $this;
    }

    /**
     * Assert that the element matching the given selector is missing the provided attribute.
     */
    public function assertAttributeMissing(string $selector, string $attribute): Page
    {
        $actual = $this->locator($selector)->getAttribute($attribute);
        expect($actual)->toBeNull("Expected element '{$selector}' not to have attribute '{$attribute}', but it had value '{$actual}'.");

        return $this;
    }

    /**
     * Assert that the element matching the given selector contains the given value in the provided attribute.
     */
    public function assertAttributeContains(string $selector, string $attribute, string $value): Page
    {
        $attributeValue = $this->locator($selector)->getAttribute($attribute);

        expect($attributeValue)->not->toBeNull("Expected element '{$selector}' to have attribute '{$attribute}', but it was not found.");

        $message = "Expected attribute '{$attribute}' of element '{$selector}' to contain '{$value}', but found '{$attributeValue}'.";
        expect(str_contains((string) $attributeValue, $value))->toBeTrue($message);

        return $this;
    }

    /**
     * Assert that the element matching the given selector does not contain the given value in the provided attribute.
     */
    public function assertAttributeDoesntContain(string $selector, string $attribute, string $value): Page
    {
        $attributeValue = $this->locator($selector)->getAttribute($attribute);

        if ($attributeValue === null) {
            return $this;
        }

        $message = "Expected attribute '{$attribute}' of element '{$selector}' not to contain '{$value}', but found '{$attributeValue}'.";
        expect(str_contains((string) $attributeValue, $value))->toBeFalse($message);

        return $this;
    }

    /**
     * Assert that the element matching the given selector has the given value in the provided aria attribute.
     */
    public function assertAriaAttribute(string $selector, string $attribute, string $value): Page
    {
        return $this->assertAttribute($selector, 'aria-'.$attribute, $value);
    }

    /**
     * Assert that the element matching the given selector has the given value in the provided data attribute.
     */
    public function assertDataAttribute(string $selector, string $attribute, string $value): Page
    {
        return $this->assertAttribute($selector, 'data-'.$attribute, $value);
    }

    /**
     * Assert that the element matching the given selector is visible.
     */
    public function assertVisible(string $selector): Page
    {
        expect($this->isVisible($selector))->toBeTrue("Expected element '{$selector}' to be visible, but it was not.");

        return $this;
    }

    /**
     * Assert that the element matching the given selector is present.
     */
    public function assertPresent(string $selector): Page
    {
        $count = $this->locator($selector)->count();
        expect($count)->toBeGreaterThan(0, "Expected element '{$selector}' to be present in the DOM, but it was not found.");

        return $this;
    }

    /**
     * Assert that the element matching the given selector is not present in the source.
     */
    public function assertNotPresent(string $selector): Page
    {
        $count = $this->locator($selector)->count();
        expect($count)->toBe(0, "Expected element '{$selector}' not to be present in the DOM, but it was found.");

        return $this;
    }

    /**
     * Assert that the element matching the given selector is not visible.
     */
    public function assertMissing(string $selector): Page
    {
        expect($this->isVisible($selector))->toBeFalse("Expected element '{$selector}' not to be visible, but it was.");

        return $this;
    }

    /**
     * Assert that the given field is enabled.
     */
    public function assertEnabled(string $field): Page
    {
        expect($this->locatorForField($field)->isEnabled())->toBeTrue("Expected field '{$field}' to be enabled, but it was disabled.");

        return $this;
    }

    /**
     * Assert that the given field is disabled.
     */
    public function assertDisabled(string $field): Page
    {
        expect($this->locatorForField($field)->isDisabled())->toBeTrue("Expected field '{$field}' to be disabled, but it was enabled.");

        return $this;
    }

    /**
     * Assert that the given button is enabled.
     */
    public function assertButtonEnabled(string $button): Page
    {
        $selector = $this->locatorForButtonPress($button);

        expect($selector->isEnabled())->toBeTrue("Expected button '{$button}' to be enabled, but it was disabled.");

        return $this;
    }

    /**
     * Assert that the given button is disabled.
     */
    public function assertButtonDisabled(string $button): Page
    {
        $selector = $this->locatorForButtonPress($button);

        expect($selector->isDisabled())->toBeTrue("Expected button '{$button}' to be disabled, but it was enabled.");

        return $this;
    }
}
