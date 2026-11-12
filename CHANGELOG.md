# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

- Require `juaniquillo/laravel-backend-component ^0.12.0` and `juaniquillo/base-backend-component ^0.1.0` directly: `HasProps`, `IsThemeable`, base contracts (`BackendComponent`, `ContentComponent`, `PathComponent`, `PropsComponent`, `ThemeComponent`, `ThemeManager`, `AttributeBag`, `CompoundComponent`) and `isBackedEnum()`/`isComponent()` now resolve from the base package; Laravel-only pieces (`HasContent`, `HasPath`, `IsBackendComponent`, `DefaultAttributeBag`, theme managers, `CellBag`, `isCellBag()`, `StaticFactory`) stay on the Laravel package.
- `SlateBackendComponent::toArray()` now matches the base `ComponentArray` shape (`name`, `component`, `attributes`, `contents`, `theme`, `path` via `getPathOnly()`, `settings`), as required by the base `BackendComponent` contract.

- Slate adapter: `SlateBackendComponent` (final, `HasProps`), `SlateComponentEnum` (206 cases), `SlateComponentFactory` + `SlateLocalThemeComponentFactory`, and four Utils (`SlateUITableUtil`, `SlateOverlayUtil`, `SlateAccordionUtil`, `SlateTabsUtil`), each with feature tests.
- Require `juaniquillo/laravel-backend-component ^0.11.0`: `Builders/` + `StaticBuilder` renamed to `Factories/` + `StaticFactory` to match upstream.
- Require Laravel `^12.0|^13.0` to match `electrik/slate`; Testbench `^10.0|^11.0`.
- Test suite: component, props, table/overlay/accordion/tabs utils, and enum coverage tests (56 tests).
- QA toolchain (Flux-style): PHPStan level 7 + Larastan, Rector (php83, dead-code, code-quality), Pint, 100% type-coverage gate, and `composer qa` running all five gates in CI.
- Pest `^4.0` (was `^3.0`) so the Laravel 13 CI leg resolves (`pest-plugin-laravel` v3 caps at Laravel 12).

## [v0.1.0] - 2026-10-04

- Initial package skeleton: service provider, Pest + Testbench suite, Pint, CI.
