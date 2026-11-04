<?php

declare(strict_types=1);

namespace Simtabi\Laranail\Ichava\IconSetsOpenmoji\Providers;

use Simtabi\Laranail\Package\Tools\Package;
use Simtabi\Laranail\Ichava\Services\IconRegistry;
use Simtabi\Laranail\Ichava\Support\ServiceProvider;
use Simtabi\Laranail\Package\Tools\Exceptions\InvalidPath;
use Simtabi\Laranail\Package\Tools\Exceptions\InvalidPackage;
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
class IconsServiceProvider extends ServiceProvider
{
    /**
     * @throws InvalidPath
     * @throws InvalidPackage
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->setName(IconsConstants::getVendorPackage())
            ->setPathFrom(source: $this, levelsUp: 2)
            ->hasConfigFile('icon-sets-openmoji');
    }

    public function bootingPackage(): void
    {
        $this->loadBladeComponent(componentClass: IconComponent::class, packageName: 'icon-sets-openmoji');

        $this->app->make(IconRegistry::class)->fromDirectory(
            $this->package->basePath('resources/assets/svg'),
            self::class,
        );
    }
}
