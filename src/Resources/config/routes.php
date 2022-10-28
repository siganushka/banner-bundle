<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Siganushka\BannerBundle\Controller\BannerController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add('siganushka_banner_getcollection', '/banners')
        ->controller([BannerController::class, 'getCollection'])
        ->methods(['GET'])
    ;

    $routes->add('siganushka_banner_postcollection', '/banners')
        ->controller([BannerController::class, 'postCollection'])
        ->methods(['POST'])
    ;

    $routes->add('siganushka_banner_getitem', '/banners/{id}')
        ->controller([BannerController::class, 'getItem'])
        ->methods(['GET'])
        ->requirements(['id' => '\d+'])
    ;

    $routes->add('siganushka_banner_putitem', '/banners/{id}')
        ->controller([BannerController::class, 'putItem'])
        ->methods(['PUT', 'PATCH'])
        ->requirements(['id' => '\d+'])
    ;

    $routes->add('siganushka_banner_deleteitem', '/banners/{id}')
        ->controller([BannerController::class, 'deleteItem'])
        ->methods(['DELETE'])
        ->requirements(['id' => '\d+'])
    ;
};
