# Changelog

All notable changes to `ichava/icon-sets-openmoji` follow [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and [Semantic Versioning](https://semver.org/).

## [Unreleased]

## [0.1.0] - 2026-11-13

First release of `ichava/icon-sets-openmoji` (owner decision D9, 2026-11-04).

### Added

- **`Category::UNCATEGORISED` (`uncategorised`, label "Uncategorised")** for the `<set>/uncategorised/` directory, where the sync keeps the 511 OpenMoji extras and component glyphs per set that Unicode's taxonomy does not name. It comes last in `Category::ordered()`, after the ten CLDR groups, and `lang/en/icons.php` and `docs/categories.md` list it. A new test fails if any category directory on disk has no `Category` case; it failed on `uncategorised` before the case existed.
- **1,436 SVGs, 718 per set, that the sync used to drop** (owner decision, 2026-11-04: add, not remove). Re-synced OpenMoji 15.1.0 on icon-sets-sync `00579ad`. 207 per set are emoji OpenMoji names without the emoji-presentation selector, now matched to their CLDR entry (the sun, the wastebasket and about 200 more), including `symbols/keycap-asterisk.svg` for `keycap: *`, which used to be lost to `keycap: #` (icon-sets-sync#91; `symbols/keycap.svg` is still `keycap: #`). 511 per set are OpenMoji extras and component glyphs the Unicode taxonomy does not name, kept as `<set>/uncategorised/<upstream-name>.svg`. Each set goes from 3,566 to 4,284 SVGs; `NoStrayTextNodesTest` is floored at 8,568. The other 3,566 changes per set are root attribute order and upstream's `color` kept, with no artwork change.

- **The OpenMoji sets, moved from `ichava/icon-sets-emoji`.** `openmoji-color` and `openmoji-black`, 3,566 SVGs each, copied byte for byte under the same item paths, grouped by Unicode CLDR category.
- **Licensing kept apart from the MIT packs.** `LICENSE` is the MIT licence for the package code; the artwork is CC-BY-SA 4.0, with its text in `resources/assets/svg/licenses/openmoji/LICENSE` and the notice and credit line in `ATTRIBUTION.md`. The pack is not part of `ichava/icon-sets-bundled`.
- **Tests:** the pack's ids resolve; the sibling, attribution, docs-shape, personal-contact, PHPStan-level and release-version guards the other packs carry.

### Changed

- **This pack requires `ichava/core` and nothing else.** `composer.json` `require` is now `php` and `ichava/core`; `illuminate/support` and `laranail/package-tools` were dropped from it and still arrive through core. The provider extends core's `IconPackServiceProvider` and declares its constants class and component class, so `src/` imports no `laranail/*` namespace; it registers the same name, path, its config file, Blade component and icon directory as before. The composer `type` is `ichava-icon-set`, which core's pack discovery reads. The README and `docs/installation.md` no longer restate the `laranail/*` repositories: they link to core's installation guide, the one place that lists them, and no longer say the pack is on Packagist, which no Ichava package is yet. `tests/Unit/CoreOnlyDependencyTest.php` fails if any of it comes back.
- **The upstream sync runs icon-sets-sync `00579ad`** (icon-sets-sync#88, icon-sets-sync#89, icon-sets-sync#90, icon-sets-sync#91), up from `5d70f5d`. icon-sets-sync#91 gives `keycap: *` its own slug, `keycap-asterisk`. icon-sets-sync#90 categorises OpenMoji 15.1.0 against Unicode 16.0, as shipped, instead of 15.1 (which would move crab, lobster, oyster, shrimp and squid), keeps the fully-qualified white flag over its FE0F-less duplicate, and stops every real emoji sync from failing on Twemoji's licence. It also carries the `split-variants` and `exclude` transforms, the build-per-OS layout and the `licence_sha256` guard. The `uses:` pin and `toolkit-ref` move together; the reusable workflow's inputs did not change between the two commits, so the caller's `with:` block is untouched.
- **`sync-upstream.yml` is a caller of icon-sets-sync's reusable `sync-pack.yml`**, pinned to a full commit SHA (icon-sets-sync#79). It builds the toolkit from source at that commit instead of `docker build` from `main`, grants `GITHUB_TOKEN` only `contents: read` and `issues: write` (the `contents`, `pull-requests` and `statuses: write` grants are gone: the Refresh Bot token does the writes), and opens an issue on an upstream licence change. The in-job Pest run and commit status are dropped; the sync pull request now starts the normal CI. `tests/Unit/SyncWorkflowCallerTest.php` pins the pin, the triggers and the permissions, and `symfony/yaml` joins `require-dev` for it.

### Removed

- **`package.replaces` and the old icon-sets-emoji ids** (owner, 2026-11-05: forward-only). icon-sets-emoji no longer ships the OpenMoji sets and ichava/core no longer aliases moved sets, so `ichava/icon-sets-emoji::openmoji-*` ids do not resolve; use `ichava/icon-sets-openmoji::openmoji-color/...`. `ReplacesEmojiTest`, its `EmojiPack`, `OldIdUse` and `CleanHost` fixtures, and the README and docs passages on moving off the old ids are gone.

### Fixed

- **The Cornwall flag no longer carries an unused `xmlns:sodipodi` declaration**, in `openmoji-color` and `openmoji-black` (`uncategorised/1f3f4-e0063-e0061-e0071-e0063-e007f.svg`). icon-sets-sync now drops a namespace declaration nothing uses (icon-sets-sync#92), and the sync runs `1c76870`, up from `00579ad`. The re-sync changed those 2 files and nothing else. js-icon-components' generator refused the declaration, so it had excluded both.
- **The OpenMoji licence text is upstream's own `LICENSE.txt`** (owner decision, 2026-11-05). The sync's licence sink writes `resources/assets/svg/licenses/openmoji/LICENSE.txt` from the OpenMoji release; it replaces the hand-placed `licenses/openmoji/LICENSE`, whose text differed from upstream's only in line wrapping. `AttributionTest`, `ATTRIBUTION.md`, the README and `docs/attribution.md` name the new path, and the test fails if the old file comes back. It failed on the old layout before the replacement.
- **`openmoji-color/travel-places/high-speed-train.svg` no longer carries a stray `d` text node** between `<g id="color">` and its first path. The defect is upstream's (OpenMoji 15.1.0 `1F684.svg` has it); the fix removes only that line. It rendered nothing but made the icon generator refuse the file. `NoStrayTextNodesTest` fails on any SVG in the pack with text directly under `<svg>` or `<g>`, floored at 7,132 files.

### Security

- **Every workflow declares a top-level `permissions: contents: read`** (S9), so its token no longer depends on the organisation's default. None of these jobs writes. `tests/Unit/WorkflowPermissionsTest.php` fails if a workflow loses the block.

### Tests

- **`tests/Unit/EmojiOpenmojiSupersetTest.php` checks that this pack holds everything icon-sets-emoji's OpenMoji sets held**, before those were removed there. `tests/fixtures/emoji-openmoji-manifest.txt` lists all 7,134 SVGs from icon-sets-emoji `openmoji-color/` and `openmoji-black/` (3,567 each, at icon-sets-emoji `23124aa`) with a sha256 prefix; every one is here at the same path, byte for byte (0 missing, 0 changed, 0 moved). A second test checks the pack holds OpenMoji art only: exactly the two OpenMoji sets, and all 8,568 SVGs on OpenMoji's 72x72 canvas with its `id="emoji"` group. Both proven red (a removed file, a planted 36x36 SVG).

### Documentation

- **The pack OpenMoji came from is named `ichava/icon-sets-twemoji`.** That pack ships Twemoji only and was renamed, forward only, so `config.json`'s description and notes, ATTRIBUTION, the architecture, attribution and sets docs, the lang and provider docblocks, `EmojiOpenmojiSupersetTest` and its manifest header, and `PackageMetadataTest` name it by its new name. The fact stays: these sets moved here byte for byte from that repository on 2026-11-04, and the manifest's commit `23124aa` is in it. No artwork or behaviour changes.
- **`config.json`'s `update_command` names the recipe that refreshes this pack.** Its note said icon-sets-sync had no recipe here and that `emoji-sets` refreshed OpenMoji inside icon-sets-emoji; the `openmoji-sets` recipe has synced this pack since icon-sets-sync#78, and icon-sets-emoji no longer carries OpenMoji. `recipe` is now `openmoji-sets`, the name icon-sets-sync uses, instead of `openmoji`. Metadata only; no SVG changed.
- **`docs/release.md` names the sync recipe that now exists** (`openmoji-sets`, icon-sets-sync#78) instead of saying the weekly sync has nothing to run.
- **The licence split is stated in the README "License" section and in `ATTRIBUTION.md`** (Q17): the root `LICENSE` is MIT and covers the package code, and the OpenMoji artwork stays CC-BY-SA 4.0 at `resources/assets/svg/licenses/openmoji/LICENSE`. `AttributionTest` now asserts both licence files exist and the README names both licences.

