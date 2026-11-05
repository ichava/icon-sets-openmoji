# Attribution

This package has two owners, and each part keeps its own licence.

| Part | Owner | Licence |
|---|---|---|
| `resources/assets/svg/files/openmoji-color/`, `openmoji-black/` | OpenMoji, HfG Schwäbisch Gmünd and contributors | CC-BY-SA 4.0, text in [`resources/assets/svg/licenses/openmoji/LICENSE.txt`](resources/assets/svg/licenses/openmoji/LICENSE.txt) |
| Everything else: the PHP, configuration, translations, tests and documentation | Simtabi LLC | MIT, see [`LICENSE`](LICENSE) |

The MIT licence in `LICENSE` covers ONLY the package code. Each emoji asset retains its original licence. Simtabi LLC packages and redistributes the emoji; it did not draw them and claims no authorship of them.

## The licence split

The root `LICENSE` is **MIT** and covers the package code only. The OpenMoji artwork stays **CC-BY-SA 4.0**, with its text at `resources/assets/svg/licenses/openmoji/LICENSE.txt`; the same split is used by `icon-sets-tabler` and `icon-sets-twemoji`.

## OpenMoji Color + OpenMoji Black

- **Set directories**:
  - `resources/assets/svg/files/openmoji-color/`
  - `resources/assets/svg/files/openmoji-black/`
- **Source**: <https://github.com/hfg-gmuend/openmoji>
- **Upstream version**: 15.1.0
- **Licence (code)**: LGPL-3.0
- **Licence (assets)**: CC-BY-SA 4.0, <https://creativecommons.org/licenses/by-sa/4.0/>
- **Attribution requirement**: credit "OpenMoji -- the open-source emoji
  and icon project. License: CC BY-SA 4.0" and link to <https://openmoji.org/>.
- **Share-alike notice**: CC-BY-SA 4.0 is *contagious for derivative works*.
  Modifying these SVGs and redistributing the modifications obliges you to
  release your modifications under CC-BY-SA 4.0. The share-alike clause
  reaches the emoji files, not your downstream code. The OpenMoji files in
  this package are not byte-identical to upstream (see "Changes" below), so
  they are distributed here under CC-BY-SA 4.0, the same licence, and must
  stay under it.

Credit line, upstream's own suggestion:

> All emojis designed by [OpenMoji](https://openmoji.org/) – the open-source emoji and icon project. License: [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/)

## Changes

Creative Commons licences ask you to indicate changes. Measured 2026-10-26
in `ichava/icon-sets-twemoji` by comparing files against upstream by codepoint:

- The files are reformatted, not redrawn. `1st-place-medal.svg` differs from
  upstream `1F947.svg` at 15.1.0 in attribute order and whitespace only
  (2,888 bytes against 2,889).
- They are renamed and grouped by Unicode CLDR name and category instead of
  codepoint.
- On 2026-11-04 they moved from `ichava/icon-sets-twemoji` to this package
  byte for byte, under the same paths.

When `ichava/core` renders an icon it also sanitises the SVG (it drops
attributes and elements outside its allow-list), prefixes every `id` so two
icons on one page cannot collide, and removes a root `width`/`height` when a
`viewBox` exists. All of these change markup, not artwork. Say so wherever you
credit the sets, e.g. "markup reformatted and sanitised for inline use".

## Where the credit has to appear

Wherever these emoji are shown to people, the page or app must carry the
credit: a footer, an "About" or a credits page is enough. Shipping this file
with the package covers redistribution of the package; it does not cover a
public page that displays the emoji.

## Index files

This package ships no generated index files. Emoji names come from the SVG
filenames and the Unicode CLDR categorisation recorded in
`resources/assets/svg/config.json`, and that configuration is MIT like the rest
of the package code.
