<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Siganushka\BannerBundle\SiganushkaBannerBundle;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $ref = new \ReflectionClass(SiganushkaBannerBundle::class);

    $routes->import(\dirname($ref->getFileName()).'/Controller', 'attribute');
};
