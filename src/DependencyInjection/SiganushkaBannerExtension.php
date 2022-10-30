<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\DependencyInjection;

use Siganushka\BannerBundle\Doctrine\EventListener\EntityToSuperclassListener;
use Siganushka\BannerBundle\Entity\Banner;
use Siganushka\BannerBundle\Repository\BannerRepository;
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

        $bannerRepositoryDef = $container->findDefinition(BannerRepository::class);
        $bannerRepositoryDef->setArgument('$entityClass', $config['banner_class']);

        $entityToSuperclassListenerDef = $container->findDefinition(EntityToSuperclassListener::class);
        $entityToSuperclassListenerDef->addTag('doctrine.event_listener', ['event' => 'loadClassMetadata']);

        if (Banner::class !== $config['banner_class']) {
            $entityToSuperclassListenerDef->setArgument(0, [Banner::class]);
        }
    }
}
