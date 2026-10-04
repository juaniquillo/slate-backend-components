# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

- Slate adapter with full Flux parity: `SlateBackendComponent` (final, `HasProps`), `SlateComponentEnum` (206 cases), `SlateComponentBuilder` + `SlateLocalThemeComponentBuilder`, `SlateUITableUtil`.
- `SlateOverlayUtil` (dialog, alert-dialog, sheet, drawer trees), `SlateAccordionUtil`, and `SlateTabsUtil`, each with feature tests.
- Require Laravel `^12.0|^13.0` to match `electrik/slate`; Testbench `^10.0|^11.0`.
- Test suite: component, props, table util, and enum coverage tests (37 tests).
- QA toolchain (Flux-style): PHPStan level 7 + Larastan, Rector (php83, dead-code, code-quality), Pint, 100% type-coverage gate, and `composer qa` running all five gates in CI.

## [v0.1.0] - 2026-10-04

- Initial package skeleton: service provider, Pest + Testbench suite, Pint, CI.
