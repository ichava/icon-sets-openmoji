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

## It requires `laranail/package-tools` directly

The provider writes `Package` into its own `configurePackage()` signature, so it depends on that
class whatever the dependency graph delivers transitively through core. **Require what you import**
is the rule; a transitive dependency is not a contract.

## It took over two sets from icon-sets-emoji

The `openmoji-color` and `openmoji-black` sets moved here from `ichava/icon-sets-emoji` byte for
byte, so every item path is unchanged. `config.json` declares the move:

```json
"replaces": [ { "package": "ichava/icon-sets-emoji", "paths": ["openmoji-color/**", "openmoji-black/**"], "since": "0.1.0" } ]
```

Core reads it at registration. With this pack installed, an old
`ichava/icon-sets-emoji::openmoji-color/...` id resolves here, icon-sets-emoji's copies of those
sets are not seeded, and each rewritten id is logged once per process as a deprecation. Doctor's
`alias.deprecated_ids` check lists the places a host still uses an old id. Without this pack the old
ids resolve in icon-sets-emoji, as before.

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
