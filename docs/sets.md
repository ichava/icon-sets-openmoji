# Sets

*Reference.*

`ichava/icon-sets-openmoji` ships **7,132 SVGs across two sets**. The `Set` enum in
`src/Enums/Set.php` is the source of truth.

| Set | SVGs | Path prefix | Style |
|---|---:|---|---|
| `openmoji-color` (default) | 3,566 | `openmoji-color/<category>/<name>` | full colour, OpenMoji house style |
| `openmoji-black` | 3,566 | `openmoji-black/<category>/<name>` | single-colour line art, follows `currentColor` |

Counts measured with `find resources/assets/svg/files/<set> -name '*.svg' | wc -l`. The vendored
upstream version is recorded in `resources/assets/svg/config.json`, not here: a version written in
two places drifts.

`openmoji-black` is the set that responds to a colour prop; `openmoji-color` carries its own fills.

## Addressing an emoji

```blade
<x-ichava::icon name="ichava/icon-sets-openmoji::openmoji-color/smileys-emotion/grinning-face" class="w-6" />
<x-ichava::icon name="ichava/icon-sets-openmoji::openmoji-black/travel-places/rocket" class="w-6 text-indigo-600" />
```

## Where the sets came from

Both sets moved here verbatim from `ichava/icon-sets-emoji`, which still ships them, deprecated, until
its 1.0.0 at the earliest. The old ids alias to this pack while it is installed; see
[Architecture](architecture.md).

---

[← Docs index](../README.md#documentation)
