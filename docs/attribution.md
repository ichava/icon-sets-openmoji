# Attribution

*Reference.*

Every SVG in this package is OpenMoji artwork, under CC-BY-SA 4.0.

| Set | Upstream | Artwork licence | Attribution required |
|---|---|---|---|
| `openmoji-color` | [OpenMoji](https://openmoji.org) | CC-BY-SA 4.0 | yes, and derivatives must stay CC-BY-SA |
| `openmoji-black` | [OpenMoji](https://openmoji.org) | CC-BY-SA 4.0 | as above |

The notice this package ships with is in [`ATTRIBUTION.md`](../ATTRIBUTION.md), and the licence text
in `resources/assets/svg/licenses/openmoji/LICENSE`. Both travel with the assets.

## What CC-BY-SA means for you

The **share-alike** term has a consequence CC-BY does not: if you modify an OpenMoji glyph and
distribute the result, that result has to be CC-BY-SA too. Recolouring `openmoji-black` with
`currentColor` at render time is not modification: you are styling, not redistributing a
derivative, but editing the artwork and shipping it is.

If that is awkward for your project, use the `twemoji` set in
[`ichava/icon-sets-emoji`](https://github.com/ichava/icon-sets-emoji), which is CC-BY and asks only
for credit. This is why OpenMoji has a pack of its own: an application takes on these terms only by
installing it.

## The integration is separately licensed

The provider, enums, component and configuration in this repository are MIT under `Simtabi LLC`
(see [`LICENSE`](../LICENSE)). The artwork licence above applies to the 8,568 SVGs this package
vendors under `resources/assets/svg/files/`. Simtabi LLC redistributes them and claims no authorship
of them.

---

[← Docs index](../README.md#documentation)
