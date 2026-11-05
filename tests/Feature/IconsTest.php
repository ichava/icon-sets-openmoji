<?php

declare(strict_types=1);

use Simtabi\Laranail\Ichava\Services\IconRegistry;
use Simtabi\Laranail\Ichava\IconSetsOpenmoji\Enums\Set;
use Simtabi\Laranail\Ichava\IconSetsOpenmoji\Enums\Category;
use Simtabi\Laranail\Ichava\IconSetsOpenmoji\Constants\IconsConstants;
use Simtabi\Laranail\Ichava\IconSetsOpenmoji\Providers\IconsServiceProvider;

it('provider boots without error', function (): void {
    $providers = array_keys($this->app->getLoadedProviders());

    $this->assertContains(
        IconsServiceProvider::class,
        $providers,
    );
});

it('constants resolve from config json', function (): void {
    $this->assertSame('ichava/icon-sets-openmoji', IconsConstants::getVendorPackage());
    $this->assertSame('OpenMoji', IconsConstants::getTitle());
    $this->assertSame('openmoji', IconsConstants::getPrefix());
});

it('set enum helpers use config prefix', function (): void {
    // The Set enum is the canonical variant axis for this pack. The
    // class helpers should namespace each set with the config prefix.
    $this->assertSame('openmoji-openmoji-color', Set::OPENMOJI_COLOR->getClass());
    $this->assertSame('openmoji-openmoji-black', Set::OPENMOJI_BLACK->getClass());
});

it('default set falls back to openmoji color', function (): void {
    // No "default": true is set on the categories in config.json, so
    // HasIconSetVariants::default() should fall through to Set::getDefaultValue(),
    // which returns OPENMOJI_COLOR as the pack-wide default.
    $default = Set::default();

    $this->assertSame(Set::OPENMOJI_COLOR, $default);
    $this->assertTrue(Set::OPENMOJI_COLOR->isDefault());
    $this->assertFalse(Set::OPENMOJI_BLACK->isDefault());
});

it('category enum lists unicode cldr groups', function (): void {
    // The 10 canonical Unicode emoji groups, in CLDR display order, then the
    // uncategorised/ bucket the sync keeps OpenMoji's extras in.
    $ordered = array_map(fn (Category $c) => $c->value, Category::ordered());

    $this->assertSame(
        [
            'smileys-emotion',
            'people-body',
            'component',
            'animals-nature',
            'food-drink',
            'travel-places',
            'activities',
            'objects',
            'symbols',
            'flags',
            'uncategorised',
        ],
        $ordered,
    );
});

it('every category directory on disk is a category case', function (): void {
    $cases = array_column(Category::cases(), 'value');
    $seen = 0;

    foreach (Set::cases() as $set) {
        $dirs = glob(dirname(__DIR__, 2) . '/resources/assets/svg/files/' . $set->value . '/*', GLOB_ONLYDIR) ?: [];
        $this->assertNotEmpty($dirs, "{$set->value} has no category directories");

        foreach ($dirs as $dir) {
            $seen++;
            $this->assertContains(basename($dir), $cases, basename($dir) . ' is a directory with no Category case');
        }
    }

    $this->assertGreaterThanOrEqual(18, $seen);
});

it('category labels are human readable', function (): void {
    // Picker UIs render `label()` directly, so this contract is
    // load-bearing for anyone consuming the enum.
    $this->assertSame('Smileys & Emotion', Category::SMILEYS_EMOTION->label());
    $this->assertSame('Animals & Nature', Category::ANIMALS_NATURE->label());
    $this->assertSame('Travel & Places', Category::TRAVEL_PLACES->label());
});

it('icon registry picks up the package', function (): void {
    /** @var IconRegistry $registry */
    $registry = $this->app->make(IconRegistry::class);

    $this->assertTrue(
        $registry->isRegistered('ichava/icon-sets-openmoji'),
        'IconRegistry should have ichava/icon-sets-openmoji registered after boot.',
    );
});
