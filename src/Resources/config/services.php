<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Siganushka\BannerBundle\SiganushkaBannerBundle;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
    ;

    $ref = new \ReflectionClass(SiganushkaBannerBundle::class);
    $services->load($ref->getNamespaceName().'\\', '../../')
        ->exclude([
            '../../DependencyInjection/',
            '../../Entity/',
            '../../SiganushkaBannerBundle.php',
        ]);
};
