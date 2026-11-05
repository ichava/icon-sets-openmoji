<?php

declare(strict_types=1);

use Simtabi\Laranail\Ichava\IconSetsOpenmoji\Enums\Set;
use Simtabi\Laranail\Ichava\IconSetsOpenmoji\Enums\Category;

/**
 * Pins the canonical `resources/` shape shared by every Ichava icon pack.
 *
 * The enum assertions are the load-bearing ones. bundled-icons shipped a
 * verbatim copy of metronic-icons' translation file -- wrong product, and
 * metronic's four categories against its own ten -- and nothing caught it,
 * because no pack registers translations and so nothing ever read the file.
 * Comparing keys against a real enum is what makes a copied file fail.
 *
 * This pack is the only one with two taxonomies, so it is the only one that
 * has to hold both in step.
 */
it('canonical paths exist', function (): void {
    foreach ([
        'assets/svg/config.json',
        'assets/svg/files',
        'lang/en/icons.php',
        'views/components',
    ] as $path) {
        $this->assertFileExists(openmoji_resources() . '/' . $path);
    }
});

it('translation group is not named after the locale', function (): void {
    // lang/en/en.php produced `<namespace>::en.name`, locale doubled.
    $this->assertFileDoesNotExist(openmoji_resources() . '/lang/en/en.php');
});

it('english does not duplicate config json metadata', function (): void {
    // config.json is canonical for name and description -- IconRegistry
    // reads it. A copy here is exactly what drifted elsewhere.
    $lang = openmoji_lang();

    $this->assertArrayNotHasKey('name', $lang);
    $this->assertArrayNotHasKey('description', $lang);
});

it('set keys match the set enum exactly', function (): void {
    $expected = array_column(Set::cases(), 'value');
    sort($expected);

    foreach (['sets', 'set_descriptions'] as $group) {
        $actual = array_keys(openmoji_lang()[$group]);
        sort($actual);

        $this->assertSame($expected, $actual, "lang/en/icons.php [{$group}] does not match the Set enum.");
    }
});

it('category keys match the category enum exactly', function (): void {
    $expected = array_column(Category::cases(), 'value');
    sort($expected);

    foreach (['categories', 'category_descriptions'] as $group) {
        $actual = array_keys(openmoji_lang()[$group]);
        sort($actual);

        $this->assertSame(
            $expected,
            $actual,
            "lang/en/icons.php [{$group}] does not match the Category enum. "
            . 'A mismatch here usually means the file was copied from another pack.',
        );
    }
});

it('every set has a directory on disk', function (): void {
    // The sets are also directories under files/. A lang key naming a set
    // that does not ship is as wrong as one that does not exist.
    foreach (Set::cases() as $set) {
        $this->assertDirectoryExists(openmoji_resources() . '/assets/svg/files/' . $set->value);
    }
});

it('config json is this package', function (): void {
    $config = json_decode(
        (string) file_get_contents(openmoji_resources() . '/assets/svg/config.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    $this->assertSame('ichava/icon-sets-openmoji', $config['package']['name']);
});

function openmoji_resources(): string
{
    return dirname(__DIR__, 2) . '/resources';
}

/** @return array<string, mixed> */
function openmoji_lang(): array
{
    return require openmoji_resources() . '/lang/en/icons.php';
}
