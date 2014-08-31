<?php

namespace Btn\ComponentBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class RendererCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $rendererId = $container->getParameter('btn_component.renderer_id');

        if (!$container->hasDefinition($rendererId)) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('btn_component.component_renderer');

        $renderers = array();
        $renderer = $container->getDefinition($rendererId);

        if ($taggedServices) {
            foreach ($taggedServices as $id => $tagAttributes) {
                foreach ($tagAttributes as $attr) {
                    $componentRenderer = $container->getDefinition($id);
                    $componentRenderer->addMethodCall('setType', array($attr['type']));
                    $renderer->addMethodCall('registerComponentRenderer', array(new Reference($id), $attr['type']));
                    $renderers[$attr['type']] = $id;
                }
            }
        }

        $container->setParameter('btn_component.component_renderers', $renderers);
    }
}
