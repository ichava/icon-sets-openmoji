# Customisation

*How-to guide.* `openmoji-color` is full-colour artwork; `openmoji-black` is line art drawn in black, so the two take styling differently.

## Size

The SVGs are square, with a `viewBox`, so any width and height utility scales them.

```blade
<x-ichava::icon name="ichava/icon-sets-openmoji::openmoji-color/people-body/man-frowning-dark-skin-tone" class="w-4 h-4" />
<x-ichava::icon name="ichava/icon-sets-openmoji::openmoji-color/people-body/man-frowning-dark-skin-tone" class="w-12 h-12" />
```

## Colour

`openmoji-color` is not recolourable: the fills are fixed in each file. `openmoji-black` strokes in `#000`; core's `svg.monochrome_to_current_color` option rewrites a monochrome icon to `currentColor`, after which `class="text-…"` and `->color()` colour it.

## Accessibility

An emoji that carries meaning needs a text alternative:

```blade
<x-ichava::icon name="ichava/icon-sets-openmoji::openmoji-color/people-body/man-frowning-dark-skin-tone" aria-label="Frowning man" class="w-6 h-6" />
```

A decorative emoji beside a text label can omit it.

## See also

- [Sets](sets.md)
- [Categories](categories.md)
- [Blade components](https://github.com/ichava/core/blob/main/docs/tools/blade-components.md)

---

[← Docs index](../README.md#documentation)
