<?php

namespace Btn\WebplatformBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class RendererCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $rendererId = $container->getParameter('btn_webplatform.renderer_id');

        if (!$container->hasDefinition($rendererId)) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('btn_webplatform.component_renderer');

        $renderers = array();
        $renderer = $container->getDefinition($rendererId);

        if ($taggedServices) {
            foreach ($taggedServices as $id => $tagAttributes) {
                foreach ($tagAttributes as $attributes) {
                    $componentRenderer = $container->getDefinition($id);
                    $componentRenderer->addMethodCall('setAlias', array($attributes['alias']));
                    $renderer->addMethodCall('registerComponentRenderer', array(new Reference($id), $attributes['alias']));
                    $renderers[$attributes['alias']] = $id;
                }
            }
        }
        $container->setParameter('btn_webplatform.component_renderers', $renderers);
    }
}
