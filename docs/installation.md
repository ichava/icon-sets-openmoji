# Installation

Three steps: point Composer at the repositories, require the pack, seed it.

## Requirements

PHP `^8.4.1 || ^8.5`, Laravel `^13`, and [`ichava/core`](https://github.com/ichava/core) `^0.1` on the same application.
Core is the engine; this pack is only icons and the provider that registers them.

## The repositories block

This pack requires `ichava/core` and nothing else; the `laranail/*` packages are core's dependencies,
not this pack's. Nothing in the Ichava family is on Packagist yet, and Composer reads `repositories`
only from the root package, so the **application's** `composer.json` names core, core's dependencies
and this pack. Core's [installation guide](https://github.com/ichava/core/blob/main/docs/installation.md#1-point-composer-at-the-repositories) holds that block and is the one place that lists
it; this pack's line is `https://github.com/ichava/icon-sets-openmoji`.

## Require it

```bash
composer require ichava/icon-sets-openmoji
```

The service provider is discovered automatically.

## Seed it

```bash
php artisan ichava::ichava-core.database seed --package=ichava/icon-sets-openmoji
```

**This step is not optional.** Until it runs the registry holds no rows for this pack and every
lookup returns nothing, which is the most common "it does not work" in the ecosystem. See
[seed pack icons](https://github.com/ichava/core/blob/main/docs/recipes/seed-pack-icons.md).

## Publish the config, only if you need it

```bash
php artisan vendor:publish --tag=ichava::icon-sets-openmoji-config
```

That writes `config/icon-sets-openmoji.php`, read back as `ichava.icon-sets-openmoji`. The defaults are merged without publishing,
so publish only to change something -- see [Configuration](configuration.md).

---

[← Docs index](../README.md#documentation)
