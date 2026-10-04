# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

- Slate adapter: `SlateBackendComponent` (final, `HasProps`), `SlateComponentEnum` (206 cases), `SlateComponentBuilder` + `SlateLocalThemeComponentBuilder`, and four Utils (`SlateUITableUtil`, `SlateOverlayUtil`, `SlateAccordionUtil`, `SlateTabsUtil`), each with feature tests.
- Require Laravel `^12.0|^13.0` to match `electrik/slate`; Testbench `^10.0|^11.0`.
- Test suite: component, props, table/overlay/accordion/tabs utils, and enum coverage tests (56 tests).
- QA toolchain (Flux-style): PHPStan level 7 + Larastan, Rector (php83, dead-code, code-quality), Pint, 100% type-coverage gate, and `composer qa` running all five gates in CI.
- Pest `^4.0` (was `^3.0`) so the Laravel 13 CI leg resolves (`pest-plugin-laravel` v3 caps at Laravel 12).

## [v0.1.0] - 2026-10-04

- Initial package skeleton: service provider, Pest + Testbench suite, Pint, CI.
