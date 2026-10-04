# Slate Backend Components

[![Tests](https://github.com/juaniquillo/slate-backend-components/actions/workflows/tests.yml/badge.svg)](https://github.com/juaniquillo/slate-backend-components/actions/workflows/tests.yml)
[![Latest Version](https://img.shields.io/github/release/juaniquillo/slate-backend-components.svg)](https://github.com/juaniquillo/slate-backend-components/releases)
[![License](https://img.shields.io/github/license/juaniquillo/slate-backend-components.svg)](LICENSE.md)
[![PHP Version](https://img.shields.io/badge/php-%5E8.3-777bb4.svg)](https://www.php.net)
[![Laravel](https://img.shields.io/badge/laravel-12%7C13-ff2d20.svg)](https://laravel.com)

Build [Slate UI](https://github.com/electrikhq/slate) interfaces from PHP. This package lets you compose Slate components in backend code — with content, attributes, props, and themes — and render them anywhere Blade renders.

## Requirements

- PHP `^8.3`
- Laravel `^12.0|^13.0`
- [Slate](https://github.com/electrikhq/slate) `^3.0` (anonymous `<x-slate::*>` Blade components)

## Installation

```bash
composer require juaniquillo/slate-backend-components
```

The service provider is auto-discovered:

```php
Juaniquillo\SlateBackendComponents\SlateBackendComponentsServiceProvider::class
```

Slate styling ships with Slate itself (`resources/css/slate.css` + Tailwind v4 tokens). No extra publish step is needed for basic use.

## Built on Laravel Backend Components

This package is a Slate-flavored adapter over [juaniquillo/laravel-backend-component](https://packagist.org/packages/juaniquillo/laravel-backend-component), which provides the underlying engine: the component model, theme managers, `CellBag`, and the generic `TableUtil`. It is installed automatically as a dependency.

What this package adds on top:

- `SlateBackendComponent` — the component class, hardcoded to the `slate::` view context
- `SlateComponentEnum` — every Slate component as a typed case (`BUTTON`, `CARD_HEADER`, `TABLE_ROW`, …)
- `SlateUITableUtil` — builds complete Slate tables from head/body arrays
- `SlateComponentBuilder` / `SlateLocalThemeComponentBuilder` — fluent factories, including app-local theme resolution

## Usage

Component props (`variant`, `loading`, `showError`, …) are passed as attributes when scalar, or as props when rich — see the [Slate documentation](https://slate.electrik.dev/components) for each component's available props.

### Components

Pick a component from the enum, set content and attributes, and render it. Components implement Laravel's `Htmlable` contract, so Blade renders them unescaped:

```php
use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;

$button = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
    ->setContent('Save changes')
    ->setAttributes(['id' => 'save-btn', 'variant' => 'primary']);

{{ $button }}
```

Or render to a string anywhere:

```php
$html = $button->toHtml();
```

Components nest via `setContents()`:

```php
$card = (new SlateBackendComponent(SlateComponentEnum::CARD))
    ->setContents([
        (new SlateBackendComponent(SlateComponentEnum::CARD_HEADER))->setContent('Account'),
        (new SlateBackendComponent(SlateComponentEnum::CARD_CONTENT))->setContent('Manage your workspace settings.'),
        (new SlateBackendComponent(SlateComponentEnum::CARD_FOOTER))->setContent('Footer'),
    ]);
```

### Builders

Fluent factories are available when you prefer them over `new`:

```php
use Juaniquillo\SlateBackendComponents\Builders\SlateComponentBuilder;
use Juaniquillo\SlateBackendComponents\Builders\SlateLocalThemeComponentBuilder;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;

$button = SlateComponentBuilder::make(SlateComponentEnum::BUTTON)
    ->setContent('Save changes');

// Resolves themes from your app's views instead of the package defaults.
$themed = SlateLocalThemeComponentBuilder::make(SlateComponentEnum::BUTTON)
    ->setTheme('color', 'success');
```

### Props

Scalar values travel as attributes, keeping the base contract intact. Anything richer — booleans, arrays, objects — travels as props:

```php
$button = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
    ->setAttribute('id', 'save-btn') // scalar attribute
    ->setProp('loading', true)       // rich prop
    ->setProps(['rows' => $orders]); // …or several at once
```

Props merge into the rendered output (winning over attributes on collision) but stay out of `toArray()`, keeping exports JSON-safe and round-trippable.

### Tables

`SlateUITableUtil` builds a complete `<x-slate::table>` tree from plain head/body arrays. Cells accept plain values, component instances, `CellBag` objects (for per-cell attributes), or `['content' => …, 'theme' => …, 'attributes' => …]` arrays:

```php
use Juaniquillo\BackendComponents\Utils\CellBag;
use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;
use Juaniquillo\SlateBackendComponents\Utils\SlateUITableUtil;

$table = SlateUITableUtil::make(
    head: ['Customer', 'Status'],
    body: [
        [
            'Alice',
            new CellBag(
                content: (new SlateBackendComponent(SlateComponentEnum::BADGE))->setContent('Paid'),
                attributes: ['variant' => 'strong'],
            ),
        ],
    ],
)
    ->setTableAttributes(['id' => 'orders'])
    ->getComponent();
```

Per-section themes are available via `setTableThemes()`, `setThThemes()`, `setTrThemes()`, and `setTdThemes()`.

## Testing

Individual checks:

- `composer analyse` — PHPStan static analysis over `src/`.
- `composer rector:check` — Rector dry-run over `src/` (use `composer rector` to apply fixes).
- `composer lint:check` — Pint style check (use `composer lint` to fix).
- `composer test:types` — enforces 100% type coverage.
- `composer test:unit` — the Pest suite.

Or run the whole gate at once — the same scripts CI executes, in order:

```bash
composer qa
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md).

## License

MIT. See [LICENSE.md](LICENSE.md).
