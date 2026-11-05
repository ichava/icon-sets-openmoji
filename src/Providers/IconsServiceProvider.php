<?php

declare(strict_types=1);

namespace Simtabi\Laranail\Ichava\IconSetsOpenmoji\Providers;

use Simtabi\Laranail\Ichava\Support\IconPackServiceProvider;
use Simtabi\Laranail\Ichava\IconSetsOpenmoji\Constants\IconsConstants;
use Simtabi\Laranail\Ichava\IconSetsOpenmoji\View\Components\IconComponent;

/**
 * Registers the OpenMoji sets with the Ichava registry.
 *
 * Ships two emoji sets, moved verbatim from ichava/icon-sets-emoji (D9):
 *
 *   - openmoji-color (community-driven flat colourful, CC-BY-SA 4.0)
 *   - openmoji-black (monochrome variant, CC-BY-SA 4.0)
 *
 * config.json declares `package.replaces`, so with this pack installed the
 * old `ichava/icon-sets-emoji::openmoji-*` ids resolve here.
 *
 * Within each set, files are grouped by Unicode CLDR category
 * (smileys-emotion, people-body, animals-nature, ...) so picker UIs
 * can browse cleanly. See ATTRIBUTION.md for source + licence details.
 */
class IconsServiceProvider extends IconPackServiceProvider
{
    protected function constantsClass(): string
    {
        return IconsConstants::class;
    }

    protected function componentClass(): string
    {
        return IconComponent::class;
    }
}
