<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Simtabi\Laranail\Ichava\Services\IconRegistry;

/*
 * The OpenMoji move (D9, contract §8), from this pack's side.
 *
 * This pack declares `package.replaces` for icon-sets-emoji's two OpenMoji
 * sets. `tests/fixtures/EmojiPack` stands in for icon-sets-emoji 0.2.0: it is
 * registered under the real name, keeps a `twemoji` set, and ships an
 * `openmoji-color` file whose fill (#ff00ff) appears nowhere in this pack, so a
 * render that reached the old pack is visible.
 */
const OPENMOJI_NEW_ID = 'ichava/icon-sets-openmoji::openmoji-color/smileys-emotion/grinning-face';
const OPENMOJI_OLD_ID = 'ichava/icon-sets-emoji::openmoji-color/smileys-emotion/grinning-face';
const OPENMOJI_OLD_FILL = '#ff00ff';

function openmoji_fixture(string $name): string
{
    return dirname(__DIR__) . '/fixtures/' . $name;
}

/** @return array{id: string, status: string, count: int, detail: list<mixed>} */
function openmoji_doctor_check(string $id): array
{
    Artisan::call('ichava::ichava-core.info', ['type' => 'doctor', '--format' => 'json']);
    $report = json_decode(Artisan::output(), true, flags: JSON_THROW_ON_ERROR);

    return collect($report['checks'])->firstWhere('id', $id);
}

it(description: 'resolves its own ids in both sets', closure: function () {
    $registry = app(IconRegistry::class);

    foreach (['openmoji-color', 'openmoji-black'] as $set) {
        $id = "ichava/icon-sets-openmoji::{$set}/smileys-emotion/grinning-face";

        expect($registry->has($id))->toBeTrue("{$id} does not resolve")
            ->and($registry->canonicalId($id))->toBe($id)
            ->and($registry->render($id))->toContain('<svg');
    }
});

it(description: 'declares the move from icon-sets-emoji as contract section 8 gives it', closure: function () {
    $config = json_decode((string) file_get_contents(dirname(__DIR__, 2) . '/resources/assets/svg/config.json'), true, flags: JSON_THROW_ON_ERROR);

    expect($config['package']['replaces'])->toBe([[
        'package' => 'ichava/icon-sets-emoji',
        'paths'   => ['openmoji-color/**', 'openmoji-black/**'],
        'since'   => '0.1.0',
    ]]);
});

it(description: 'says 0.1.0 and prefers this pack, never a 0.2.0 that will not exist', closure: function () {
    $root = dirname(__DIR__, 2);
    $fixture = json_decode((string) file_get_contents(openmoji_fixture('EmojiPack') . '/config.json'), true, flags: JSON_THROW_ON_ERROR);

    expect($fixture['metadata']['data']['categories']['openmoji-color']['deprecated'])->toBe(['since' => '0.1.0', 'replacement' => 'ichava/icon-sets-openmoji']);

    foreach (['README.md', 'docs/sets.md', 'docs/getting-started.md', 'docs/architecture.md'] as $file) {
        expect(str_contains((string) file_get_contents("{$root}/{$file}"), '0.2.0'))->toBeFalse("{$file} names a version that will not exist");
    }

    expect((string) file_get_contents("{$root}/docs/sets.md"))->toContain('preferred since 0.1.0')
        ->and((string) file_get_contents("{$root}/README.md"))->toContain('preferred since 0.1.0');
});

it(description: 'resolves the old icon-sets-emoji ids here when both packs are installed', closure: function () {
    $registry = app(IconRegistry::class);
    $registry->fromDirectory(openmoji_fixture('EmojiPack'));

    expect($registry->canonicalId(OPENMOJI_OLD_ID))->toBe(OPENMOJI_NEW_ID)
        ->and($registry->canonicalId('ichava/icon-sets-emoji::openmoji-black/smileys-emotion/grinning-face'))
        ->toBe('ichava/icon-sets-openmoji::openmoji-black/smileys-emotion/grinning-face')
        ->and($registry->has(OPENMOJI_OLD_ID))->toBeTrue()
        ->and($registry->render(OPENMOJI_OLD_ID))->toBe($registry->render(OPENMOJI_NEW_ID))
        ->and($registry->render(OPENMOJI_OLD_ID))->not->toContain(OPENMOJI_OLD_FILL)
        ->and($registry->isReplaced('ichava/icon-sets-emoji', 'openmoji-color/smileys-emotion/grinning-face'))->toBeTrue()
        // The set icon-sets-emoji keeps stays where it is.
        ->and($registry->canonicalId('ichava/icon-sets-emoji::twemoji/smileys-emotion/grinning-face'))
        ->toBe('ichava/icon-sets-emoji::twemoji/smileys-emotion/grinning-face');
});

it(description: 'has doctor report a use of an old id, and no missing replacement', closure: function () {
    app(IconRegistry::class)->fromDirectory(openmoji_fixture('EmojiPack'));
    $this->app->useConfigPath(openmoji_fixture('CleanHost'));

    $this->app->useAppPath(openmoji_fixture('OldIdUse/app'));
    $planted = openmoji_doctor_check('alias.deprecated_ids');

    expect($planted['status'])->toBe('warn')
        ->and($planted['count'])->toBe(1)
        ->and($planted['detail'][0]['location'])->toEndWith('OldIdUse/app/Hero.php:7')
        ->and($planted['detail'][0]['replacement_installed'])->toBeTrue()
        ->and(openmoji_doctor_check('alias.replacement_missing')['count'])->toBe(0);

    $this->app->useAppPath(openmoji_fixture('CleanHost/app'));

    expect(openmoji_doctor_check('alias.deprecated_ids')['count'])->toBe(0);
});
