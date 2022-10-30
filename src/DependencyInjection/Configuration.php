<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\DependencyInjection;

use Siganushka\BannerBundle\Entity\Banner;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress MissingClosureParamType
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('siganushka_banner');
        /** @var ArrayNodeDefinition */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('banner_class')
                    ->defaultValue(Banner::class)
                    ->validate()
                    ->ifTrue(function ($v) {
                        if (!class_exists($v)) {
                            return false;
                        }

                        return !is_subclass_of($v, Banner::class);
                    })
                    ->thenInvalid('The %s class must extends '.Banner::class.' for using the "banner_class".')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
