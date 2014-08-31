<?php

namespace Btn\ComponentBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class HydratorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $hydratorId = $container->getParameter('btn_component.hydrator_id');

        if (!$container->hasDefinition($hydratorId)) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('btn_component.component_hydrator');

        $hydrators = array();
        $hydrator = $container->getDefinition($hydratorId);

        if ($taggedServices) {
            foreach ($taggedServices as $id => $tagAttributes) {
                foreach ($tagAttributes as $attr) {
                    $componentHydrator = $container->getDefinition($id);
                    $componentHydrator->addMethodCall('setType', array($attr['type']));
                    $hydrator->addMethodCall('registerComponentHydrator', array(new Reference($id), $attr['type']));
                    $hydrators[$attr['type']] = $id;
                }
            }
        }

        $container->setParameter('btn_component.component_hydrators', $hydrators);
    }
}
