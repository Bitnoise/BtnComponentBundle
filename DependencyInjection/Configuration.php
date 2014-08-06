<?php

namespace Btn\WebplatformBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('btn_webplatform');

        $rootNode
            ->children()
                ->scalarNode('component_class')->isRequired()->cannotBeEmpty()->end()

                ->scalarNode('container_provider_class')->defaultValue('Btn\WebplatformBundle\Provider\ContainerProvider')->end()
                ->scalarNode('container_provider_id')->defaultValue('btn_webplatform.container_provider.default')->end()

                ->scalarNode('component_provider_class')->defaultValue('Btn\WebplatformBundle\Provider\ComponentProvider')->end()
                ->scalarNode('component_provider_id')->defaultValue('btn_webplatform.component_provider.default')->end()

                ->scalarNode('provider_class')->defaultValue('Btn\WebplatformBundle\Provider\Provider')->end()
                ->scalarNode('provider_id')->defaultValue('btn_webplatform.provider.default')->end()

                ->scalarNode('hydrator_class')->defaultValue('Btn\WebplatformBundle\Hydrator\Hydrator')->end()
                ->scalarNode('hydrator_id')->defaultValue('btn_webplatform.hydrator.default')->end()

                ->scalarNode('renderer_class')->defaultValue('Btn\WebplatformBundle\Renderer\Renderer')->end()
                ->scalarNode('renderer_id')->defaultValue('btn_webplatform.renderer.default')->end()

                ->scalarNode('manager_class')->defaultValue('Btn\WebplatformBundle\Manager\Manager')->end()
                ->scalarNode('manager_id')->defaultValue('btn_webplatform.manager.default')->end()

                ->arrayNode('containers')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->isRequired()->end()
                            ->booleanNode('editable')->defaultValue(false)->end()
                            ->booleanNode('manageable')->defaultValue(false)->end()
                            ->arrayNode('avalible_components')
                                ->defaultValue(array())
                                ->treatNullLike(array())
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('control')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('component_manager')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('index_template')->defaultValue('BtnWebplatformBundle:ComponentManager:index.html.twig')->end()
                                ->scalarNode('list_template')->defaultValue('BtnWebplatformBundle:ComponentManager:list.html.twig')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end()
        ;

        return $treeBuilder;
    }
}
