# Changelog

All notable changes to `ichava/icon-sets-openmoji` follow [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Fixed

- **`openmoji-color/travel-places/high-speed-train.svg` no longer carries a stray `d` text node** between `<g id="color">` and its first path. The defect is upstream's (OpenMoji 15.1.0 `1F684.svg` has it); the fix removes only that line. It rendered nothing but made the icon generator refuse the file. `NoStrayTextNodesTest` fails on any SVG in the pack with text directly under `<svg>` or `<g>`, floored at 7,132 files.

### Documentation

- **`docs/release.md` names the sync recipe that now exists** (`openmoji-sets`, icon-sets-sync#78) instead of saying the weekly sync has nothing to run.
- **The licence split is stated in the README "License" section and in `ATTRIBUTION.md`** (Q17): the root `LICENSE` is MIT and covers the package code, and the OpenMoji artwork stays CC-BY-SA 4.0 at `resources/assets/svg/licenses/openmoji/LICENSE`. `AttributionTest` now asserts both licence files exist and the README names both licences.

### Changed

- **`sync-upstream.yml` is a caller of icon-sets-sync's reusable `sync-pack.yml`**, pinned to a full commit SHA (icon-sets-sync#79). It builds the toolkit from source at that commit instead of `docker build` from `main`, grants `GITHUB_TOKEN` only `contents: read` and `issues: write` (the `contents`, `pull-requests` and `statuses: write` grants are gone: the Refresh Bot token does the writes), and opens an issue on an upstream licence change. The in-job Pest run and commit status are dropped; the sync pull request now starts the normal CI. `tests/Unit/SyncWorkflowCallerTest.php` pins the pin, the triggers and the permissions, and `symfony/yaml` joins `require-dev` for it.

### Security

- **Every workflow declares a top-level `permissions: contents: read`** (S9), so its token no longer depends on the organisation's default. None of these jobs writes. `tests/Unit/WorkflowPermissionsTest.php` fails if a workflow loses the block.

## [0.1.0] - TBD

First release of `ichava/icon-sets-openmoji` (owner decision D9, 2026-11-04).

### Added

- **The OpenMoji sets, moved from `ichava/icon-sets-emoji`.** `openmoji-color` and `openmoji-black`, 3,566 SVGs each, copied byte for byte under the same item paths, grouped by Unicode CLDR category.
- **`package.replaces` in `config.json`** declares the move, so with this pack installed ichava/core resolves `ichava/icon-sets-emoji::openmoji-color/...` and `openmoji-black/...` ids here, stops seeding icon-sets-emoji's copies, and logs each rewritten id once as a deprecation. Without this pack the old ids keep resolving in icon-sets-emoji.
- **Licensing kept apart from the MIT packs.** `LICENSE` is the MIT licence for the package code; the artwork is CC-BY-SA 4.0, with its text in `resources/assets/svg/licenses/openmoji/LICENSE` and the notice and credit line in `ATTRIBUTION.md`. The pack is not part of `ichava/icon-sets-bundled`.
- **Tests:** the pack's ids resolve; with an icon-sets-emoji registered beside it, the old ids resolve here and doctor reports a planted use of one; the sibling, attribution, docs-shape, personal-contact, PHPStan-level and release-version guards the other packs carry.
