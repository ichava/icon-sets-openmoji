<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| OpenMoji -- localisable strings
|--------------------------------------------------------------------------
|
| An overlay, not a second source of truth. `name` and `description` are
| deliberately absent: IconRegistry::fromDirectory() reads those from
| resources/assets/svg/config.json, which is canonical. Keeping a copy here
| is what let the two drift apart in the packs that already had a lang file,
| while nothing was reading it. A non-English locale may add them to
| override; `en` must not.
|
| Like ichava/icon-sets-emoji, which it came from, this pack has two
| taxonomies, so it has both `sets` and `categories`:
|
|   sets       -> Simtabi\Laranail\Ichava\IconSetsOpenmoji\Enums\Set
|   categories -> Simtabi\Laranail\Ichava\IconSetsOpenmoji\Enums\Category
|
| Set names are proper nouns from their upstream projects and are NOT
| translated -- only their descriptions are.
|
*/

return [
    'sets' => [
        'openmoji-color' => 'OpenMoji Color',
        'openmoji-black' => 'OpenMoji Black',
    ],

    'set_descriptions' => [
        'openmoji-color' => 'OpenMoji in full colour, from the HfG Schwäbisch Gmünd project',
        'openmoji-black' => 'OpenMoji as single-colour outlines, for monochrome contexts',
    ],

    'categories' => [
        'smileys-emotion' => 'Smileys & Emotion',
        'people-body'     => 'People & Body',
        'component'       => 'Components',
        'animals-nature'  => 'Animals & Nature',
        'food-drink'      => 'Food & Drink',
        'travel-places'   => 'Travel & Places',
        'activities'      => 'Activities',
        'objects'         => 'Objects',
        'symbols'         => 'Symbols',
        'flags'           => 'Flags',
    ],

    'category_descriptions' => [
        'smileys-emotion' => 'Faces, expressions and emotional states',
        'people-body'     => 'People, body parts, gestures and professions',
        'component'       => 'Modifier components such as skin tones and hair styles',
        'animals-nature'  => 'Animals, plants and the natural world',
        'food-drink'      => 'Food, drink and utensils',
        'travel-places'   => 'Places, buildings, transport and landmarks',
        'activities'      => 'Sport, games, celebration and the arts',
        'objects'         => 'Everyday objects, tools and technology',
        'symbols'         => 'Signs, arrows, marks and abstract symbols',
        'flags'           => 'National, regional and thematic flags',
    ],
];
