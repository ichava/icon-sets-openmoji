# Changelog

All notable changes to `ichava/icon-sets-openmoji` follow [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Documentation

- **The licence split is stated in the README "License" section and in `ATTRIBUTION.md`** (Q17): the root `LICENSE` is MIT and covers the package code, and the OpenMoji artwork stays CC-BY-SA 4.0 at `resources/assets/svg/licenses/openmoji/LICENSE`. `AttributionTest` now asserts both licence files exist and the README names both licences.

## [0.1.0] - TBD

First release of `ichava/icon-sets-openmoji` (owner decision D9, 2026-11-04).

### Added

- **The OpenMoji sets, moved from `ichava/icon-sets-emoji`.** `openmoji-color` and `openmoji-black`, 3,566 SVGs each, copied byte for byte under the same item paths, grouped by Unicode CLDR category.
- **`package.replaces` in `config.json`** declares the move, so with this pack installed ichava/core resolves `ichava/icon-sets-emoji::openmoji-color/...` and `openmoji-black/...` ids here, stops seeding icon-sets-emoji's copies, and logs each rewritten id once as a deprecation. Without this pack the old ids keep resolving in icon-sets-emoji.
- **Licensing kept apart from the MIT packs.** `LICENSE` is the MIT licence for the package code; the artwork is CC-BY-SA 4.0, with its text in `resources/assets/svg/licenses/openmoji/LICENSE` and the notice and credit line in `ATTRIBUTION.md`. The pack is not part of `ichava/icon-sets-bundled`.
- **Tests:** the pack's ids resolve; with an icon-sets-emoji registered beside it, the old ids resolve here and doctor reports a planted use of one; the sibling, attribution, docs-shape, personal-contact, PHPStan-level and release-version guards the other packs carry.
