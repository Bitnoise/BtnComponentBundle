<?php

namespace Btn\ComponentBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('btn_component');

        $rootNode
            ->children()

                ->arrayNode('component')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('provider_id')->defaultValue('btn_component.component_provider.default')->end()
                    ->end()
                ->end()
                ->arrayNode('container')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue(null)->end()
                        ->scalarNode('provider_id')->defaultValue('btn_component.container_provider.default')->end()
                        ->scalarNode('manager_id')->defaultValue('btn_component.container_manager.default')->end()
                    ->end()
                ->end()

                ->scalarNode('provider_id')->defaultValue('btn_component.provider.default')->end()
                ->scalarNode('hydrator_id')->defaultValue('btn_component.hydrator.default')->end()
                ->scalarNode('renderer_id')->defaultValue('btn_component.renderer.default')->end()
                ->scalarNode('manager_id')->defaultValue('btn_component.manager.default')->end()

                ->arrayNode('components')
                    ->beforeNormalization()
                        ->ifArray()
                        ->then(function ($v) {
                            foreach ($v as $key => $value) {
                                if (is_string($value) || is_null($value)) {
                                    $v[$key] = array('title' => $value);
                                }
                                if (empty($value['name'])) {
                                    $v[$key]['name'] = $key;
                                }
                            }

                            return $v;
                        })
                    ->end()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->defaultValue(null)->end()
                            ->scalarNode('title')->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('containers')
                    ->beforeNormalization()
                        ->ifArray()
                        ->then(function ($v) {
                            foreach ($v as $key => $value) {
                                if (empty($value['name'])) {
                                    $v[$key]['name'] = $key;
                                }
                            }

                            return $v;
                        })
                    ->end()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->defaultValue(null)->end()
                            ->scalarNode('title')->isRequired()->end()
                            ->booleanNode('editable')->defaultValue(false)->end()
                            ->booleanNode('manageable')->defaultValue(false)->end()
                            ->arrayNode('parameters')
                                    ->children()
                                        ->arrayNode('avalible_components')
                                            ->prototype('scalar')->end()
                                        ->end()
                                    ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('templates')
                    ->defaultValue(array())
                    ->prototype('array')
                        ->children()
                            ->scalarNode('template')->isRequired()->cannotBeEmpty()->example('BtnComponentBundle:Templates:example.html.twig')->end()
                            ->scalarNode('title')->isRequired()->cannotBeEmpty()->example('Example template')->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('node_content_provider')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('container')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enabled')->defaultTrue()->end()
                                ->scalarNode('route_name')->defaultValue('btn_component_container_show')->end()
                            ->end()
                        ->end()
                        ->arrayNode('template')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enabled')->defaultTrue()->end()
                                ->scalarNode('route_name')->defaultValue('btn_component_template_show')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end()
        ;

        return $treeBuilder;
    }
}
