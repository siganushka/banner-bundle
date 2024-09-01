<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\DependencyInjection;

use Siganushka\BannerBundle\Entity\Banner;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
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
                        ->ifTrue(static fn (mixed $v): bool => !is_a($v, Banner::class, true))
                        ->thenInvalid('The value must be instanceof '.Banner::class.', %s given.')
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
