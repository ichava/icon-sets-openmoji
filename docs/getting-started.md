# Getting started

*How-to guide.* Your first icon from this pack, once [Installation](installation.md) is done.

## Render one

```blade
<x-ichava::icon name="ichava/icon-sets-openmoji::openmoji-color/smileys-emotion/grinning-face" class="w-6 h-6" />
```

The component is core's and is generic: the pack is named in the path, not in the tag. Which
`set` values this pack accepts is the subject of [Sets](sets.md).

## Or from PHP

```blade
{{ ichava('ichava/icon-sets-openmoji::openmoji-black/smileys-emotion/grinning-face')->class('w-5 h-5') }}
```

Both spellings of the path resolve to the same icon -- slash and dot are normalised by one
resolver, documented in core's [icon path format](https://github.com/ichava/core/blob/main/docs/tools/icon-path-format.md).

## Coming from icon-sets-emoji

Ids you already use, such as `ichava/icon-sets-emoji::openmoji-color/smileys-emotion/grinning-face`,
keep working: with this pack installed they resolve here, and each is logged once as a use of the older id. The emoji pack's copies stay supported in v0.1.0, and this pack is the one to install for new work.
Rewrite them to `ichava/icon-sets-openmoji::...` at your own pace; doctor lists where they are:

```bash
php artisan ichava::ichava-core.info doctor
```

## If nothing renders

Almost always the seed has not run. Check with:

```bash
php artisan ichava::ichava-core.info icons --package=ichava/icon-sets-openmoji
```

Zero rows means [Installation](installation.md) step 4 is outstanding. Core's
[troubleshooting](https://github.com/ichava/core/blob/main/docs/troubleshooting.md) covers the rest.

## See also

- [Sets](sets.md) -- what this pack ships and how to address it
- [Use an icon pack](https://github.com/ichava/core/blob/main/docs/recipes/use-an-icon-pack.md) -- the generic guide, for any pack

---

[← Docs index](../README.md#documentation)
