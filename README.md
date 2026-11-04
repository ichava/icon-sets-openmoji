# ichava/icon-sets-openmoji

[![Tests](https://github.com/ichava/icon-sets-openmoji/actions/workflows/tests.yml/badge.svg)](https://github.com/ichava/icon-sets-openmoji/actions/workflows/tests.yml)
[![Static analysis](https://github.com/ichava/icon-sets-openmoji/actions/workflows/code-quality.yml/badge.svg)](https://github.com/ichava/icon-sets-openmoji/actions/workflows/code-quality.yml)

Two badges, not four: the pack is not on Packagist yet, so there is no registry version to show, and the artwork is CC-BY-SA 4.0 rather than MIT (the code is MIT; see [License](#license)).

> OpenMoji for the Ichava Laravel icon ecosystem: 7,132 SVGs in two sets, OpenMoji colour and OpenMoji black.

Requires [`ichava/core`](https://github.com/ichava/core) `^0.1` on PHP `^8.4.1 || ^8.5` and Laravel `^13`.

## Install

The `laranail/*` packages core depends on are not on Packagist yet, and neither is this pack, so the **application's** `composer.json` names them:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/ichava/icon-sets-openmoji" },
        { "type": "vcs", "url": "https://github.com/laranail/package-tools" },
        { "type": "vcs", "url": "https://github.com/laranail/console" },
        { "type": "vcs", "url": "https://github.com/laranail/enumerator" },
        { "type": "vcs", "url": "https://github.com/laranail/db-tools" }
    ]
}
```

Then require the pack:

```bash
composer require ichava/icon-sets-openmoji
```

The service provider is discovered automatically. Core's [installation guide](https://github.com/ichava/core/blob/main/docs/installation.md) covers core's own setup.

## Quick start guide and usage

### Getting started

Seed the pack once after installing it, and again after upgrading it:

```bash
php artisan ichava::ichava-core.database seed --package=ichava/icon-sets-openmoji
```

The seed is not optional: until it runs the registry holds no rows for this pack and every lookup returns nothing. No configuration is needed; the defaults are merged without publishing anything.

Coming from `ichava/icon-sets-emoji`: these sets moved here from it, and this is the pack to install for new work (preferred since 0.1.0). The emoji pack's copies stay supported in v0.1.0. With this pack installed, the old `ichava/icon-sets-emoji::openmoji-*` ids resolve here and are logged as deprecated; `php artisan ichava::ichava-core.info doctor` lists where you still use them.

### Usage

Icons are addressed as `ichava/icon-sets-openmoji::<set>/<category>/<name>`. In Blade, through core's component:

```blade
<x-ichava::icon name="ichava/icon-sets-openmoji::openmoji-color/smileys-emotion/grinning-face" class="w-6 h-6" />
```

Or from PHP, through core's helper:

```blade
{{ ichava('ichava/icon-sets-openmoji::openmoji-black/smileys-emotion/grinning-face')->class('w-6 h-6') }}
```

See [Getting started](docs/getting-started.md) for the full walkthrough, and the [Documentation](#documentation) index below for everything else.

## <a name="documentation"></a>Documentation

The full documentation lives in this repository, under `docs/`, and is indexed below.

### This pack

- [Installation](docs/installation.md) — requirements, the repositories block, seeding
- [Getting started](docs/getting-started.md) — your first icon from this pack, and moving off the old ids
- [Configuration](docs/configuration.md) — this pack's config key, and what is core's instead
- [Architecture](docs/architecture.md) — what it ships, the move from icon-sets-emoji, and why
- [Release](docs/release.md) — how a version is cut, and when the core floor moves
- [Sets](docs/sets.md) — the two sets, their counts, and how to address them
- [Categories](docs/categories.md) — the category tree
- [Attribution](docs/attribution.md) — the CC-BY-SA terms and what they mean for you

### Shared across every pack

- [Use an icon pack](https://github.com/ichava/core/blob/main/docs/recipes/use-an-icon-pack.md) — addressing icons, in Blade and in PHP
- [Seed pack icons](https://github.com/ichava/core/blob/main/docs/recipes/seed-pack-icons.md) — the seeding pipeline and its options
- [Check pack updates](https://github.com/ichava/core/blob/main/docs/recipes/check-pack-updates.md) — the update checker and what its statuses mean
- [Serve icons from a CDN](https://github.com/ichava/core/blob/main/docs/recipes/serve-icons-from-a-cdn.md) — reading this pack's CDN templates out of `config.json`

Its upstream is `OpenMoji`; run core's [check pack updates](https://github.com/ichava/core/blob/main/docs/recipes/check-pack-updates.md) recipe to see whether a newer release exists.

## Contributing & security

See [CONTRIBUTING.md](CONTRIBUTING.md). Report vulnerabilities privately through [security policy](https://github.com/ichava/icon-sets-openmoji/security/policy) — never in a public issue.

## License

Two licences apply, split by file. The package code is **MIT**, © Simtabi LLC, and the root [LICENSE](LICENSE) is that MIT text. The OpenMoji artwork is **CC-BY-SA 4.0**, and its licence text is `resources/assets/svg/licenses/openmoji/LICENSE`.

The emoji keep that licence and Simtabi LLC claims no authorship of them. OpenMoji requires credit wherever the emoji are shown, and its share-alike term binds anything you derive from the artwork, not your application's code; the credit line and terms are in [ATTRIBUTION.md](ATTRIBUTION.md), which ships with the package.
