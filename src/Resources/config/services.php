<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Siganushka\BannerBundle\Controller\BannerController;
use Siganushka\BannerBundle\Form\Type\BannerType;
use Siganushka\BannerBundle\Media\BannerImg;
use Siganushka\BannerBundle\Repository\BannerRepository;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(BannerController::class)
            ->autoconfigure()
            ->autowire()
            ->tag('controller.service_arguments')

        ->set('siganushka_banner.repository.banner', BannerRepository::class)
            ->arg(0, service('doctrine'))
            ->arg(1, param('siganushka_banner.banner_class'))
            ->tag('doctrine.repository_service')
            ->alias(BannerRepository::class, 'siganushka_banner.repository.banner')

        ->set('siganushka_banner.form.type.banner', BannerType::class)
            ->tag('form.type')

        ->set('siganushka_banner.media.channel.banner', BannerImg::class)
            ->tag('siganushka_media.channel')
    ;
};
