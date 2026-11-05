<?php

declare(strict_types=1);

namespace Simtabi\Laranail\Ichava\IconSetsOpenmoji\Tests;

use Simtabi\Laranail\Ichava\Testing\PackTestCase;
use Simtabi\Laranail\Ichava\IconSetsOpenmoji\Providers\IconsServiceProvider;

/**
 * Boots core and this pack, on the database `DB_CONNECTION` names and a
 * non-serialising array cache: core's PackTestCase, which every pack shares.
 */
abstract class TestCase extends PackTestCase
{
    protected function packProvider(): string
    {
        return IconsServiceProvider::class;
    }
}
