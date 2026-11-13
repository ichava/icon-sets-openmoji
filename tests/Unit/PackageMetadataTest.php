<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Package metadata, in a file of its own
|--------------------------------------------------------------------------
|
| This assertion used to sit at the bottom of ResourceShapeTest.php, below a
| PHPUnit class. Pest treats a file containing top-level it()/test() calls as
| a Pest file and does not collect the class in it, so adding this one line
| silently switched off every test_* method above it -- seven here, nineteen
| across the three packs that had it. Nothing failed; the suite simply got
| smaller, and the enum guards that catch a copied translation file stopped
| running.
|
| Keep Pest functions and PHPUnit classes in separate files.
|
*/

it(description: 'points metadata.repository at this package, not its upstream', closure: function () {
    $config = json_decode(
        (string) file_get_contents(dirname(__DIR__, 2) . '/resources' . '/assets/svg/config.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    // Settled 2026-09-21. `metadata.repository` is THIS package's repository.
    //
    // It had drifted to naming the upstream in two packs and was blank in a
    // third, so the field meant three different things across five packs. The
    // stub already defines it as ours for every new pack; `icon-sets.json` pins
    // ours and hands it to `latestTag()`, which only resolves against our tags;
    // and the browser API groups it with package_name, vendor, version and
    // license -- package metadata, not provenance.
    //
    // Upstream identity is not homeless: the `upstream` block carries source,
    // version, version_check_url, licence, CDN and update command in full, and
    // `metadata.homepage` points at the upstream's own site where one exists.
    expect($config['metadata']['repository'])->toBe('https://github.com/ichava/icon-sets-openmoji');
});

it(description: 'points metadata.homepage at OpenMoji, not at this package', closure: function () {
    $config = json_decode(
        (string) file_get_contents(dirname(__DIR__, 2) . '/resources' . '/assets/svg/config.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    // Settled 2026-09-22 for the family. `metadata.homepage` is the UPSTREAM
    // project's own site. icon-sets-twemoji omits it and names Twemoji in
    // `metadata.authors`; this pack names OpenMoji's site.
    // Pointing it at this package would duplicate `metadata.repository` in the
    // browser API, where `publicMetadata()` ships both side by side.
    expect($config['metadata']['homepage'])->toBe('https://openmoji.org/')
        ->and($config['metadata']['homepage'])->not->toBe($config['metadata']['repository']);
});

it(description: 'declares no package.replaces: openmoji-* ids under icon-sets-twemoji are not aliased', closure: function () {
    $config = json_decode(
        (string) file_get_contents(dirname(__DIR__, 2) . '/resources/assets/svg/config.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    expect($config['package'])->toHaveKey('name')
        ->and($config['package'])->not->toHaveKey('replaces');
});
