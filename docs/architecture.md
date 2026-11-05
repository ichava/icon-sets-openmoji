# Architecture

*Explanation.* What this pack is, what it delegates, and why it is shaped that way.

## What it ships

8,568 SVGs, addressed by sets -- see [Sets](sets.md). Counted from
the tracked files rather than quoted from prose:

```bash
git ls-tree -r --name-only origin/main -- resources/assets/svg/files | grep -c '\.svg$'
```

Besides the assets it ships a provider, a constants class, an enum for its addressing axis, and a
Blade component extending core's. That is the whole surface.

## It depends on core, and core does not depend on it

The pack registers its icon directory with core's `IconRegistry` during `bootingPackage()`, after
core's singletons are bound. Registering earlier -- in `registeringPackage()` -- reaches for services
that do not exist yet, and logging there raises `Log [ichava] not defined`.

Core discovers installed packs at runtime. It has no list of them, so a pack is added by installing
it and removed by removing it.

## It requires `ichava/core` only

`composer.json` requires `php` and `ichava/core`, and nothing under `src/` names a class from any
other `Simtabi\Laranail` namespace. The provider extends core's `IconPackServiceProvider` and declares
its constants class and its component class; core writes the `laranail/package-tools` signature, so
the `laranail/*` packages reach this pack only through core. The composer `type` is
`ichava-icon-set`, which is how core's pack discovery finds it. `tests/Unit/CoreOnlyDependencyTest.php`
fails if any of that changes.

## Where the sets came from

The `openmoji-color` and `openmoji-black` sets moved here from `ichava/icon-sets-twemoji` byte for
byte, so every item path is unchanged. icon-sets-twemoji no longer ships them, and an
`ichava/icon-sets-twemoji::openmoji-*` id does not resolve: the id is
`ichava/icon-sets-openmoji::openmoji-color/...`.

Why a pack of its own: OpenMoji is CC-BY-SA 4.0. Keeping it apart means only an application that
installs this pack takes on the share-alike and attribution terms, and it keeps the pack out of
`ichava/icon-sets-bundled`, whose eligibility gate admits no CC-BY-SA set.

## Upstream

Its upstream is [OpenMoji](https://github.com/hfg-gmuend/openmoji), and the version these SVGs came from is recorded in
`resources/assets/svg/config.json` under `upstream.current_version` rather than written out
here, so the two cannot drift. Core's [check pack updates](https://github.com/ichava/core/blob/main/docs/recipes/check-pack-updates.md)
recipe reports whether a newer release exists.

## See also

- [Core architecture](https://github.com/ichava/core/blob/main/docs/architecture.md) -- topology, boot order, the registry
- [Attribution](attribution.md) -- the upstream project and its licence
- [Release](release.md)

---

[← Docs index](../README.md#documentation)
