<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\DependencyInjection;

use Siganushka\BannerBundle\Entity\Banner;
use Siganushka\BannerBundle\Repository\BannerRepository;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class SiganushkaBannerExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('services.php');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $bannerRepositoryDef = $container->findDefinition(BannerRepository::class);
        $bannerRepositoryDef->setArgument('$entityClass', $config['banner_class']);
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (!$container->hasExtension('siganushka_generic')) {
            return;
        }

        $configs = $container->getExtensionConfig($this->getAlias());

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $overrideMappings = [];
        if (Banner::class !== $config['banner_class']) {
            $overrideMappings[] = Banner::class;
        }

        $container->prependExtensionConfig('siganushka_generic', [
            'doctrine' => ['entity_to_superclass' => $overrideMappings],
        ]);
    }
}
