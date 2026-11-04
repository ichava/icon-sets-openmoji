<?php

declare(strict_types=1);

use Simtabi\Laranail\Ichava\Services\IconRegistry;

/**
 * Pins the SVG kind this pack declares in `config.json`, `icon` or `illustration`.
 *
 * Core resolves a category's kind as its own `kind`, then `package.kind`, then
 * `icon`, and ignores a value that names no kind. So a typo here does not fail
 * anywhere at runtime: it files the SVGs as icons and nothing reports it. These
 * cases are what make it fail.
 *
 * The category is the first folder under `files/`, which is the folder core
 * files an icon under, so the folders on disk are resolved as well as the
 * categories `config.json` declares.
 */
function openmoji_kind_config(): array
{
    return json_decode(
        (string) file_get_contents(dirname(__DIR__, 2) . '/resources/assets/svg/config.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );
}

/** @return list<string> */
function openmoji_kinds(): array
{
    return ['icon', 'illustration'];
}

/** @return array<string, string> category slug => the kind it resolves to */
function openmoji_resolved_kinds(): array
{
    $config = openmoji_kind_config();
    $packageKind = $config['package']['kind'] ?? 'icon';
    $categories = $config['metadata']['data']['categories'] ?? [];

    $slugs = array_keys($categories);

    foreach (glob(dirname(__DIR__, 2) . '/resources/assets/svg/files/*', GLOB_ONLYDIR) ?: [] as $directory) {
        $slugs[] = basename($directory);
    }

    $kinds = [];

    foreach (array_unique($slugs) as $slug) {
        $kinds[$slug] = $categories[$slug]['kind'] ?? $packageKind;
    }

    ksort($kinds);

    return $kinds;
}

it(description: 'declares a pack-wide kind core recognises', closure: function () {
    $package = openmoji_kind_config()['package'];

    expect(array_key_exists('kind', $package))->toBeTrue('config.json package.kind is missing');
    expect(in_array($package['kind'], openmoji_kinds(), true))
        ->toBeTrue("config.json package.kind is '{$package['kind']}', which names no kind");
});

it(description: 'declares only kinds core recognises on its categories', closure: function () {
    $declared = [];

    foreach (openmoji_kind_config()['metadata']['data']['categories'] ?? [] as $slug => $category) {
        if (array_key_exists('kind', $category)) {
            $declared[$slug] = $category['kind'];
        }
    }

    // Empty is fine: a category that names no kind inherits the pack's.
    expect(array_diff($declared, openmoji_kinds()))->toBe([]);
});

it(description: 'resolves a kind for every category', closure: function () {
    $kinds = openmoji_resolved_kinds();

    // A glob or a key that matches nothing would make the loop below vacuous.
    expect($kinds)->not->toBeEmpty('no categories were inspected');

    foreach ($kinds as $slug => $kind) {
        expect(in_array($kind, openmoji_kinds(), true))
            ->toBeTrue("category {$slug} resolves to '{$kind}', which names no kind");
    }
});

it(description: 'files exactly the expected categories as illustrations', closure: function () {
    $illustrations = array_keys(array_filter(
        openmoji_resolved_kinds(),
        static fn (string $kind): bool => $kind === 'illustration',
    ));

    expect($illustrations)->toBe([]);
});

it(description: 'resolves the same kinds through core', closure: function () {
    if (! method_exists(IconRegistry::class, 'kindFor')) {
        $this->markTestSkipped(
            'the ichava/core resolved here predates SVG kinds (IconRegistry::kindFor, ichava/core#148); '
            . 'the config.json cases above still run',
        );
    }

    $registry = $this->app->make(IconRegistry::class);

    foreach (openmoji_resolved_kinds() as $slug => $kind) {
        expect($registry->kindFor('ichava/icon-sets-openmoji', $slug)->value)->toBe($kind);
    }
});
