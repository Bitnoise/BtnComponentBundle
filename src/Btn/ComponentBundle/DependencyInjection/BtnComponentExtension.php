<?php

namespace Btn\ComponentBundle\DependencyInjection;

use Btn\BaseBundle\DependencyInjection\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BtnComponentExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);

        $config = $this->getProcessedConfig($container, $configs);

        $container->setParameter('btn_component.component.class', $config['component']['class']);
        $container->setParameter('btn_component.container.class', $config['container']['class']);
        $container->setParameter('btn_component.container.manageable', $config['container']['manageable']);

        $container->setParameter('btn_component.container.manager_id', $config['container']['manager_id']);
        $container->setParameter('btn_component.container.provider_id', $config['container']['provider_id']);
        $container->setParameter('btn_component.component.provider_id', $config['component']['provider_id']);

        $container->setParameter('btn_component.provider_id', $config['provider_id']);
        $container->setParameter('btn_component.hydrator_id', $config['hydrator_id']);
        $container->setParameter('btn_component.renderer_id', $config['renderer_id']);
        $container->setParameter('btn_component.manager_id', $config['manager_id']);

        $container->setAlias('btn_component.container_provider', $config['container']['provider_id']);
        $container->setAlias('btn_component.component_provider', $config['component']['provider_id']);
        $container->setAlias('btn_component.container_manager', $config['container']['manager_id']);
        $container->setAlias('btn_component.provider', $config['provider_id']);
        $container->setAlias('btn_component.hydrator', $config['hydrator_id']);
        $container->setAlias('btn_component.renderer', $config['renderer_id']);
        $container->setAlias('btn_component.manager', $config['manager_id']);

        $container->setParameter('btn_component.containers', $config['containers']);
        $container->setParameter('btn_component.components', $config['components']);
        $container->setParameter('btn_component.layouts', $config['layouts']);

        $container->setParameter('btn_component.node_content_provider.container', $config['node_content_provider']['container']);
        $container->setParameter('btn_component.node_content_provider.layout', $config['node_content_provider']['layout']);

        $this->addClassesToCompile(array(
            'Btn\\ComponentBundle\\EventListener\\HydratorSubscriber',
            'Btn\\ComponentBundle\\Hydrator\\AbstractComponentHydrator',
            'Btn\\ComponentBundle\\Hydrator\\ComponentHydratorInterface',
            'Btn\\ComponentBundle\\Hydrator\\Hydrator',
            'Btn\\ComponentBundle\\Hydrator\\HydratorInterface',
            'Btn\\ComponentBundle\\Manager\\Manager',
            'Btn\\ComponentBundle\\Manager\\ManagerInterface',
            'Btn\\ComponentBundle\\Model\\ComponentInterface',
            'Btn\\ComponentBundle\\Model\\HydratableInterface',
            'Btn\\ComponentBundle\\Provider\\ContainerProvider',
            'Btn\\ComponentBundle\\Provider\\ContainerProviderInterface',
            'Btn\\ComponentBundle\\Provider\\ComponentProvider',
            'Btn\\ComponentBundle\\Provider\\ComponentProviderInterface',
            'Btn\\ComponentBundle\\Renderer\\AbstractComponentRenderer',
            'Btn\\ComponentBundle\\Renderer\\ComponentRendererInterface',
            'Btn\\ComponentBundle\\Renderer\\Renderer',
            'Btn\\ComponentBundle\\Renderer\\RendererInterface',
            'Btn\\ComponentBundle\\View\\ComponentView',
            'Btn\\ComponentBundle\\View\\ContainerView',
        ));
    }
}
