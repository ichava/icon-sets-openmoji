<?php

declare(strict_types=1);

namespace Simtabi\Laranail\Ichava\IconSetsOpenmoji\View\Components;

use Simtabi\Laranail\Ichava\IconSetsOpenmoji\Constants\IconsConstants;
use Simtabi\Laranail\Ichava\View\Components\IconComponent as BaseIconComponent;

/**
 * Blade component for the icon-sets-openmoji pack.
 *
 * Usage:
 *
 *   {{-- Full form: pick a set + Unicode CLDR group + slug --}}
 *   <x-icon-sets-openmoji-icon name="openmoji-black/smileys-emotion/grinning-face" />
 *
 *   {{-- Default set (openmoji-color) -- short form skips the set segment --}}
 *   <x-icon-sets-openmoji-icon name="smileys-emotion/grinning-face" />
 *
 *   {{-- Via the generic Ichava engine --}}
 *   <x-ichava::icon name="ichava/icon-sets-openmoji::openmoji-color/flags/flag-japan" />
 */
class IconComponent extends BaseIconComponent
{
    protected function getIconSet(): string
    {
        return IconsConstants::getPackageName();
    }

    protected function getVendorPackage(): string
    {
        return IconsConstants::getVendorPackage();
    }
}
