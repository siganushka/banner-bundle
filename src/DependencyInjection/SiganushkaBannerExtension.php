<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\DependencyInjection;

use Siganushka\BannerBundle\Entity\Banner;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SiganushkaBannerExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('services.php');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('siganushka_banner.banner_class', $config['banner_class']);

        if (Banner::class === $config['banner_class']) {
            $container->removeDefinition('siganushka_banner.doctrine.listener.entity_to_superclass');
        }
    }
}
