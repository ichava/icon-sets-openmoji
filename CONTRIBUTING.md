# Contributing

Contribution guidelines are centralized for the whole Ichava org:

- [Code of Conduct](https://github.com/ichava/.github/blob/main/CODE_OF_CONDUCT.md)

For this pack specifically: icon assets are refreshed from upstream by the
[icon-sets-sync](https://github.com/ichava/icon-sets-sync/blob/main/docs/maintainer-sync.md).
Please do not hand-edit generated SVGs; contribute fixes to the sync recipe
or the upstream source instead.

## Releases and versioning

- **A version tag is pushed only for final code.** `vX.Y.Z` marks a release, nothing else. To try a
  release build first, push a pre-release tag, `vX.Y.Z-rc.N`, which uses up no release number. It runs
  the same release workflow and publishes as a GitHub pre-release. It needs no CHANGELOG section of
  its own: the workflow uses a `## [X.Y.Z-rc.N]` section when the commit has one, and a fixed
  test-build note otherwise.
- **A public tag is never moved, deleted or reused.** Once a tag has been fetched, moving it makes
  consumers of the same version disagree. Composer and npm git dependencies resolve the tag afresh, so
  new installs get the moved commit while every existing lockfile and cache keeps the old one (an npm
  registry version cannot be republished at all). For a Go module, the module proxy keeps the copy it
  first served and `sum.golang.org` records its checksum, so `go` fetches after the move fail
  verification. The next fix gets the next number.
- **A tag ruleset enforces this.** Applied once the v0.1.0 tags are pushed, it blocks deleting,
  updating and force-pushing `v*` tags on this repository. The v0.1.0 publication as a
  single commit was the one planned exception.
- **A bad release is retracted, not replaced.** Name it in the CHANGELOG and the GitHub release notes, and leave it listed on Packagist, which has no per-version retraction (only a whole package can be marked abandoned). Then ship the fix as the next
  version.
