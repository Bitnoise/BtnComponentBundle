<?php

namespace Btn\WebplatformBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BtnWebplatformExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('btn_webplatform.container_show_route_name', $config['container_show_route_name']);

        $container->setParameter('btn_webplatform.component_class', $config['component_class']);
        $container->setParameter('btn_webplatform.container_class', $config['container_class']);

        $container->setParameter('btn_webplatform.container_provider_class', $config['container_provider_class']);
        $container->setParameter('btn_webplatform.container_provider_id', $config['container_provider_id']);

        $container->setParameter('btn_webplatform.component_provider_class', $config['component_provider_class']);
        $container->setParameter('btn_webplatform.component_provider_id', $config['component_provider_id']);

        $container->setParameter('btn_webplatform.provider_class', $config['provider_class']);
        $container->setParameter('btn_webplatform.provider_id', $config['provider_id']);

        $container->setParameter('btn_webplatform.hydrator_class', $config['hydrator_class']);
        $container->setParameter('btn_webplatform.hydrator_id', $config['hydrator_id']);

        $container->setParameter('btn_webplatform.renderer_class', $config['renderer_class']);
        $container->setParameter('btn_webplatform.renderer_id', $config['renderer_id']);

        $container->setParameter('btn_webplatform.container_manager_class', $config['container_manager_class']);
        $container->setParameter('btn_webplatform.container_manager_id', $config['container_manager_id']);

        $container->setParameter('btn_webplatform.manager_class', $config['manager_class']);
        $container->setParameter('btn_webplatform.manager_id', $config['manager_id']);

        $container->setAlias('btn_webplatform.container_provider', $config['container_provider_id']);
        $container->setAlias('btn_webplatform.component_provider', $config['component_provider_id']);
        $container->setAlias('btn_webplatform.provider', $config['provider_id']);
        $container->setAlias('btn_webplatform.hydrator', $config['hydrator_id']);
        $container->setAlias('btn_webplatform.renderer', $config['renderer_id']);
        $container->setAlias('btn_webplatform.container_manager', $config['container_manager_id']);
        $container->setAlias('btn_webplatform.manager', $config['manager_id']);

        $container->setParameter('btn_webplatform.containers', $config['containers']);
        $container->setParameter('btn_webplatform.components', $config['components']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->addClassesToCompile(array(
            'Btn\\WebplatformBundle\\EventListener\\HydratorSubscriber',
            'Btn\\WebplatformBundle\\Hydrator\\AbstractComponentHydrator',
            'Btn\\WebplatformBundle\\Hydrator\\ComponentHydratorInterface',
            'Btn\\WebplatformBundle\\Hydrator\\Hydrator',
            'Btn\\WebplatformBundle\\Hydrator\\HydratorInterface',
            'Btn\\WebplatformBundle\\Manager\\Manager',
            'Btn\\WebplatformBundle\\Manager\\ManagerInterface',
            'Btn\\WebplatformBundle\\Model\\ComponentInterface',
            'Btn\\WebplatformBundle\\Model\\HydratableInterface',
            'Btn\\WebplatformBundle\\Provider\\ContainerProvider',
            'Btn\\WebplatformBundle\\Provider\\ContainerProviderInterface',
            'Btn\\WebplatformBundle\\Provider\\ComponentProvider',
            'Btn\\WebplatformBundle\\Provider\\ComponentProviderInterface',
            'Btn\\WebplatformBundle\\Renderer\\AbstractComponentRenderer',
            'Btn\\WebplatformBundle\\Renderer\\ComponentRendererInterface',
            'Btn\\WebplatformBundle\\Renderer\\Renderer',
            'Btn\\WebplatformBundle\\Renderer\\RendererInterface',
            'Btn\\WebplatformBundle\\View\\ComponentView',
            'Btn\\WebplatformBundle\\View\\ContainerView',
        ));
    }
}
