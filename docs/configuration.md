# Configuration

*Reference.* What this pack's config file holds, and what belongs to core instead.

## The file and its key

`config/icon-sets-openmoji.php`, merged at `ichava.icon-sets-openmoji`. **The filename must match the package short name** -- a
different name silently doubles the key and every read returns `null`, which shipped undetected in
this ecosystem once before.

```bash
php artisan vendor:publish --tag=ichava::icon-sets-openmoji-config
```

Publishing is optional; the defaults are merged either way.

## What is here

One key, `default_set`: the set an unqualified emoji resolves to (`openmoji-color`, the default, or `openmoji-black`; `ICHAVA_OPENMOJI_DEFAULT_SET`).

The set name and prefix are not here. Core reads both from `resources/assets/svg/config.json`
through `IconsConstants`, which is canonical for the pack's name, prefix, kind, variants and
categories; the copies this file used to carry were read by nothing and are gone.

## What is not here

Cache, queue, database, logging, security and the `ICHAVA_*` environment surface are **core's**, and
apply to every pack at once. They are documented in core's
[configuration guide](https://github.com/ichava/core/blob/main/docs/configuration.md) and [environment variables](https://github.com/ichava/core/blob/main/docs/environment.md).

A value set here cannot change how core seeds, caches or sanitises; that is the point of the split.

---

[← Docs index](../README.md#documentation)
