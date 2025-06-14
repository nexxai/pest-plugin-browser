# Pest Plugin Browser

This repository contains the Pest Plugin Browser.

> If you want to start testing your application with Pest, visit the main **[Pest Repository](https://github.com/pestphp/pest)**.

## Community & Resources

-   Explore our docs at **[pestphp.com »](https://pestphp.com)**
-   Follow us on Twitter at **[@pestphp »](https://twitter.com/pestphp)**
-   Join us at **[discord.gg/kaHY6p54JH »](https://discord.gg/kaHY6p54JH)** or **[t.me/+kYH5G4d5MV83ODk0 »](https://t.me/+kYH5G4d5MV83ODk0)**
-   Follow the creator Nuno Maduro:
    -   YouTube: **[youtube.com/@nunomaduro](https://www.youtube.com/@nunomaduro)** — Videos every weekday
    -   Twitch: **[twitch.tv/enunomaduro](https://www.twitch.tv/enunomaduro)** — Streams (almost) every weekday
    -   Twitter / X: **[x.com/enunomaduro](https://x.com/enunomaduro)**
    -   LinkedIn: **[linkedin.com/in/nunomaduro](https://www.linkedin.com/in/nunomaduro)**
    -   Instagram: **[instagram.com/enunomaduro](https://www.instagram.com/enunomaduro)**
    -   Tiktok: **[tiktok.com/@enunomaduro](https://www.tiktok.com/@enunomaduro)**

## Installation (for development purposes)

1. Install PHP dependencies using Composer:

```bash
composer install
```

2. Install Node.js dependencies:

```bash
npm install
```

3. Install Playwright browsers:

```bash
npx playwright install
```

## Running Tests

To run the test suite, execute:

```bash
./vendor/bin/pest
```

## The Playground

![Playground_interacting-with-elements.png](docs/Playground_interacting-with-elements.png)

For each Operation/Assertion, we add a corresponding Test.

We can make use of the `playground()->url()` helper, to get its URL during the test.

We can provide a URI that will be appended, e.g: `playground()->url('/test/interactive-elements')`.

```php
$this->visit(playground()->url('/test/interactive-elements'))
    ->assertUrlIs(playground()->url('/test/interactive-elements'))
```

### Routes and views for testing

Check the `playground/resources/views/test-pages` folder for existing views.

They are accessible by the playground route `/test/{page}`.

E.g.: The view `resources/views/test-pages/interactive-elements.blade.php` is visited
on `playground()->url('/test/interactive-elements')`.

The playground is standard Laravel App, where you may add a page with a feature for your test.

Just add the view, and the Nav Menu will automatically update based on the view name.

## License

Pest is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.

# Documentation

Pest Plugin Browser brings end-to-end testing to the elegant syntax from Pest.
This allows to test your application in a browser environment, enabling to test all the components, such as frontend,
backend and database.

## Installation

TBD

## Available Operations

-   [url](#url)
-   [goto](#goto)
-   [title](#title)
-   [getAttribute](#getattribute)
-   [querySelector](#queryselector) / [querySelectorAll](#queryselectorall)
-   [locator](#locator)
-   [getByRole](#getbyrole)
-   [getByTestId](#getbytestid)
-   [getByAltText](#getbyalttext)
-   [getByLabel](#getbylabel)
-   [getByPlaceholder](#getbyplaceholder)
-   [getByText](#getbytext)
-   [getByTitle](#getbytitle)
-   [content](#content)
-   [isEnabled](#isenabled)
-   [isVisible](#isvisible)
-   [isHidden](#ishidden)
-   [isEditable](#iseditable)
-   [isDisabled](#isdisabled)
-   [isChecked](#ischecked)
-   [fill](#fill)
-   [innerText](#innertext)
-   [textContent](#textcontent)
-   [inputValue](#inputvalue)
-   [check](#check)
-   [uncheck](#uncheck)
-   [hover](#hover)
-   [focus](#focus)
-   [press](#press)
-   [type](#type)
-   [waitForLoadState](#waitforloadstate)
-   [waitForURL](#waitforurl)
-   [waitForSelector](#waitforselector)
-   [dragAndDrop](#draganddrop)
-   [setContent](#setcontent)
-   [selectOption](#selectoption)
-   [evaluate](#evaluate)
-   [evaluateHandle](#evaluatehandle)
-   [forward](#forward)
-   [back](#back)
-   [reload](#reload)
-   [screenshot](#screenshot)
-   [locator.click](#locatorclick)
-   [locator.fill](#locatorfill)
-   [locator.type](#locatortype)
-   [locator.press](#locatorpress)
-   [locator.check](#locatorcheck)
-   [locator.uncheck](#locatoruncheck)
-   [locator.isVisible](#locatorisvisible)
-   [locator.isHidden](#locatorishidden)
-   [locator.isEnabled](#locatorisenabled)
-   [locator.isDisabled](#locatorisdisabled)
-   [locator.isEditable](#locatoriseditable)
-   [locator.isChecked](#locatorischecked)
-   [locator.textContent](#locatortextcontent)
-   [locator.innerText](#locatorinnertext)
-   [locator.inputValue](#locatorinputvalue)
-   [locator.getAttribute](#locatorgetattribute)
-   [locator.screenshot](#locatorscreenshot)

---

### url

Get the current URL of the page.

```php
$page = page('/test/frame-tests');
$currentUrl = $page->url();
```

### goto

Navigate to a given URL.

```php
$page = page('/test/frame-tests');
$page->goto('https://example.com');
```

### title

Get the meta title of the page.

```php
$page = page('/test/frame-tests');
$title = $page->title();
```

### getAttribute

Get the value of an attribute for a selector.

```php
$page = page('/test/frame-tests');
$id = $page->getAttribute('h1', 'id');
```

### querySelector / querySelectorAll

Find elements by selector.

```php
$page = page('/test/frame-tests');
$element = $page->querySelector('h1');
$elements = $page->querySelectorAll('div');
```

### locator

Create a locator for a selector.

```php
$page = page('/test/frame-tests');
$locator = $page->locator('button.submit');
```

### getByRole

Create a locator by ARIA role.

```php
$page = page('/test/frame-tests');
$button = $page->getByRole('button');
```

### getByTestId

Create a locator by test id.

```php
$page = page('/test/frame-tests');
$testElement = $page->getByTestId('login-form');
```

### getByAltText

Create a locator by alt text.

```php
$page = page('/test/frame-tests');
$image = $page->getByAltText('Logo');
```

### getByLabel

Create a locator by label text.

```php
$page = page('/test/frame-tests');
$input = $page->getByLabel('Email');
```

### getByPlaceholder

Create a locator by placeholder text.

```php
$page = page('/test/frame-tests');
$input = $page->getByPlaceholder('Enter your email');
```

### getByText

Create a locator by text content.

```php
$page = page('/test/frame-tests');
$link = $page->getByText('Sign In');
```

### getByTitle

Create a locator by title attribute.

```php
$page = page('/test/frame-tests');
$element = $page->getByTitle('Main Section');
```

### content

Get the full HTML contents of the page.

```php
$page = page('/test/frame-tests');
$html = $page->content();
```

### isEnabled

Check if an element is enabled.

```php
$page = page('/test/frame-tests');
$isEnabled = $page->isEnabled('button.submit');
```

### isVisible

Check if an element is visible.

```php
$page = page('/test/frame-tests');
$isVisible = $page->isVisible('h1');
```

### isHidden

Check if an element is hidden.

```php
$page = page('/test/frame-tests');
$isHidden = $page->isHidden('h1');
```

### isEditable

Check if an element is editable.

```php
$page = page('/test/frame-tests');
$isEditable = $page->isEditable('input[type="text"]');
```

### isDisabled

Check if an element is disabled.

```php
$page = page('/test/frame-tests');
$isDisabled = $page->isDisabled('button.submit');
```

### isChecked

Check if a checkbox or radio is checked.

```php
$page = page('/test/frame-tests');
$isChecked = $page->isChecked('input[type="checkbox"]');
```

### fill

Fill a form field.

```php
$page = page('/test/frame-tests');
$page->fill('input[name="email"]', 'jane@doe.com');
```

### innerText

Get the inner text of an element.

```php
$page = page('/test/frame-tests');
$text = $page->innerText('h1');
```

### textContent

Get the text content of an element.

```php
$page = page('/test/frame-tests');
$content = $page->textContent('h1');
```

### inputValue

Get the value of an input element.

```php
$page = page('/test/frame-tests');
$value = $page->inputValue('input[name="email"]');
```

### check

Check a checkbox or radio button.

```php
$page = page('/test/frame-tests');
$page->check('input[type="checkbox"]');
```

### uncheck

Uncheck a checkbox or radio button.

```php
$page = page('/test/frame-tests');
$page->uncheck('input[type="checkbox"]');
```

### hover

Hover over an element.

```php
$page = page('/test/frame-tests');
$page->hover('button');
```

### focus

Focus an element.

```php
$page = page('/test/frame-tests');
$page->focus('input[name="email"]');
```

### press

Press a key on an element.

```php
$page = page('/test/frame-tests');
$page->press('input[name="email"]', 'Enter');
```

### type

Type text into an element.

```php
$page = page('/test/frame-tests');
$page->type('input[name="email"]', 'hello world');
```

### waitForLoadState

Wait for the page to reach a certain load state.

```php
$page = page('/test/frame-tests');
$page->waitForLoadState('networkidle');
```

### waitForURL

Wait for the page to reach a certain URL.

```php
$page = page('/test/frame-tests');
$page->waitForURL('https://example.com/next');
```

### waitForSelector

Wait for a selector to appear or reach a state.

```php
$page = page('/test/frame-tests');
$page->waitForSelector('h1');
```

### dragAndDrop

Drag one element to another.

```php
$page = page('/test/frame-tests');
$page->dragAndDrop('#source', '#target');
```

### setContent

Set the HTML content of the page.

```php
$page = page('/test/frame-tests');
$page->setContent('<h1>Hello</h1>');
```

### selectOption

Select options in a <select> element.

```php
$page = page('/test/frame-tests');
$page->selectOption('select[name="country"]', 'US');
```

### evaluate

Run JavaScript in the page context.

```php
$page = page('/test/frame-tests');
$result = $page->evaluate('() => document.title');
```

### evaluateHandle

Run JavaScript and return a handle.

```php
$page = page('/test/frame-tests');
$handle = $page->evaluateHandle('() => window');
```

### forward

Navigate forward in browser history.

```php
$page = page('/test/frame-tests');
$page->forward();
```

### back

Navigate back in browser history.

```php
$page = page('/test/frame-tests');
$page->back();
```

### reload

Reload the current page.

```php
$page = page('/test/frame-tests');
$page->reload();
```

### screenshot

Take a screenshot of the page.

```php
$page = page('/test/frame-tests');
$page->screenshot('example.png');
```

### locator.click
Click the element found by the locator.
```php
$locator = $page->locator('button.submit');
$locator->click();
```

### locator.fill
Fill an input or textarea found by the locator.
```php
$locator = $page->locator('input[name="email"]');
$locator->fill('hello@pestphp.com');
```

### locator.type
Type text into the element found by the locator.
```php
$locator = $page->locator('input[name="email"]');
$locator->type('hello world');
```

### locator.press
Press a key on the element found by the locator.
```php
$locator = $page->locator('input[name="email"]');
$locator->press('Enter');
```

### locator.check
Check a checkbox or radio button found by the locator.
```php
$locator = $page->locator('input[type="checkbox"]');
$locator->check();
```

### locator.uncheck
Uncheck a checkbox or radio button found by the locator.
```php
$locator = $page->locator('input[type="checkbox"]');
$locator->uncheck();
```

### locator.isVisible
Check if the element found by the locator is visible.
```php
$locator = $page->locator('h1');
$isVisible = $locator->isVisible();
```

### locator.isHidden
Check if the element found by the locator is hidden.
```php
$locator = $page->locator('h1');
$isHidden = $locator->isHidden();
```

### locator.isEnabled
Check if the element found by the locator is enabled.
```php
$locator = $page->locator('button.submit');
$isEnabled = $locator->isEnabled();
```

### locator.isDisabled
Check if the element found by the locator is disabled.
```php
$locator = $page->locator('button.submit');
$isDisabled = $locator->isDisabled();
```

### locator.isEditable
Check if the element found by the locator is editable.
```php
$locator = $page->locator('input[type="text"]');
$isEditable = $locator->isEditable();
```

### locator.isChecked
Check if a checkbox or radio button found by the locator is checked.
```php
$locator = $page->locator('input[type="checkbox"]');
$isChecked = $locator->isChecked();
```

### locator.textContent
Get the text content of the element found by the locator.
```php
$locator = $page->locator('h1');
$content = $locator->textContent();
```

### locator.innerText
Get the inner text of the element found by the locator.
```php
$locator = $page->locator('h1');
$text = $locator->innerText();
```

### locator.inputValue
Get the value of an input element found by the locator.
```php
$locator = $page->locator('input[name="email"]');
$value = $locator->inputValue();
```

### locator.getAttribute
Get an attribute value from the element found by the locator.
```php
$locator = $page->locator('h1');
$id = $locator->getAttribute('id');
```

### locator.screenshot
Take a screenshot of the element found by the locator.
```php
$locator = $page->locator('h1');
$locator->screenshot('element.png');
```

## Available Expectations

### toHaveTitle

Checks that the page has the given title.

```php
expect($page)->toHaveTitle('My Page Title');
```

### toBeChecked

Checks that the locator is checked (for checkboxes/radios).

```php
expect($locator)->toBeChecked();
```

### toBeVisible

Checks that the locator is visible on the page.

```php
expect($locator)->toBeVisible();
```

### toBeEnabled

Checks that the locator is enabled (not disabled).

```php
expect($locator)->toBeEnabled();
```

### toBeDisabled

Checks that the locator is disabled.

```php
expect($locator)->toBeDisabled();
```

### toBeEditable

Checks that the locator is editable (input, textarea, etc.).

```php
expect($locator)->toBeEditable();
```

### toBeHidden

Checks that the locator is hidden from view.

```php
expect($locator)->toBeHidden();
```

### toHaveId

Checks that the locator has the given id attribute.

```php
expect($locator)->toHaveId('element-id');
```

### toHaveClass

Checks that the locator has the given class attribute.

```php
expect($locator)->toHaveClass('class-name');
```

### toHaveRole

Checks that the locator has the given ARIA role.

```php
expect($locator)->toHaveRole('button');
```

### toBeEmpty

Checks that the locator's text content is empty.

```php
expect($locator)->toBeEmpty();
```

### toHaveValue

Checks that the locator has a value (for input elements).

```php
expect($locator)->toHaveValue('expected-value');
```

### toHaveScreenshot

The `toHaveScreenshot` expectation takes a screenshot of the current page and saves it to the specified path. It then checks that the screenshot file exists at that path. This is useful for verifying that screenshots are being generated correctly during browser tests.

**Usage:**

```php
$page = page('/test/frame-tests');
$screenshotName = 'screenshot.png';
expect($page)->toHaveScreenshot($screenshotName);
expect(file_exists(\Pest\Browser\Support\Screenshot::path($screenshotName)))->toBeTrue();
```

If the screenshot cannot be saved (e.g., due to an invalid or unwritable path), the expectation will fail and throw an exception.

```php
$page = page('/test/frame-tests');
$invalidPath = '/invalid-dir/not-the-screenshot.png';
expect($page)->toHaveScreenshot($invalidPath); // This will throw an exception
```
