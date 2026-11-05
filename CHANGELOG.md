# Changelog

All notable changes to `ichava/icon-sets-openmoji` follow [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Added

- **`Category::UNCATEGORISED` (`uncategorised`, label "Uncategorised")** for the `<set>/uncategorised/` directory, where the sync keeps the 511 OpenMoji extras and component glyphs per set that Unicode's taxonomy does not name. It comes last in `Category::ordered()`, after the ten CLDR groups, and `lang/en/icons.php` and `docs/categories.md` list it. A new test fails if any category directory on disk has no `Category` case; it failed on `uncategorised` before the case existed.
- **1,436 SVGs, 718 per set, that the sync used to drop** (owner decision, 2026-11-04: add, not remove). Re-synced OpenMoji 15.1.0 on icon-sets-sync `00579ad`. 207 per set are emoji OpenMoji names without the emoji-presentation selector, now matched to their CLDR entry (the sun, the wastebasket and about 200 more), including `symbols/keycap-asterisk.svg` for `keycap: *`, which used to be lost to `keycap: #` (icon-sets-sync#91; `symbols/keycap.svg` is still `keycap: #`). 511 per set are OpenMoji extras and component glyphs the Unicode taxonomy does not name, kept as `<set>/uncategorised/<upstream-name>.svg`. Each set goes from 3,566 to 4,284 SVGs; `NoStrayTextNodesTest` is floored at 8,568. The other 3,566 changes per set are root attribute order and upstream's `color` kept, with no artwork change.

### Fixed

- **The OpenMoji licence text is upstream's own `LICENSE.txt`** (owner decision, 2026-11-05). The sync's licence sink writes `resources/assets/svg/licenses/openmoji/LICENSE.txt` from the OpenMoji release; it replaces the hand-placed `licenses/openmoji/LICENSE`, whose text differed from upstream's only in line wrapping. `AttributionTest`, `ATTRIBUTION.md`, the README and `docs/attribution.md` name the new path, and the test fails if the old file comes back. It failed on the old layout before the replacement.
- **`openmoji-color/travel-places/high-speed-train.svg` no longer carries a stray `d` text node** between `<g id="color">` and its first path. The defect is upstream's (OpenMoji 15.1.0 `1F684.svg` has it); the fix removes only that line. It rendered nothing but made the icon generator refuse the file. `NoStrayTextNodesTest` fails on any SVG in the pack with text directly under `<svg>` or `<g>`, floored at 7,132 files.

### Documentation

- **This pack is stated plainly as the one to install for new work** (preferred since 0.1.0), and icon-sets-emoji's copies of the OpenMoji sets as supported in v0.1.0, with no removal date. The older "deprecated since 0.2.0" wording is gone (0.2.0 will not exist). `tests/Feature/ReplacesEmojiTest.php` asserts the wording and both resolution paths.
- **`docs/release.md` names the sync recipe that now exists** (`openmoji-sets`, icon-sets-sync#78) instead of saying the weekly sync has nothing to run.
- **The licence split is stated in the README "License" section and in `ATTRIBUTION.md`** (Q17): the root `LICENSE` is MIT and covers the package code, and the OpenMoji artwork stays CC-BY-SA 4.0 at `resources/assets/svg/licenses/openmoji/LICENSE`. `AttributionTest` now asserts both licence files exist and the README names both licences.

### Changed

- **The upstream sync runs icon-sets-sync `00579ad`** (icon-sets-sync#88, icon-sets-sync#89, icon-sets-sync#90, icon-sets-sync#91), up from `5d70f5d`. icon-sets-sync#91 gives `keycap: *` its own slug, `keycap-asterisk`. icon-sets-sync#90 categorises OpenMoji 15.1.0 against Unicode 16.0, as shipped, instead of 15.1 (which would move crab, lobster, oyster, shrimp and squid), keeps the fully-qualified white flag over its FE0F-less duplicate, and stops every real emoji sync from failing on Twemoji's licence. It also carries the `split-variants` and `exclude` transforms, the build-per-OS layout and the `licence_sha256` guard. The `uses:` pin and `toolkit-ref` move together; the reusable workflow's inputs did not change between the two commits, so the caller's `with:` block is untouched.
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
