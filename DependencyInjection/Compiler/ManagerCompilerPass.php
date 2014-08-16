<?php

namespace Btn\ComponentBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ManagerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $managerId = $container->getParameter('btn_component.manager_id');

        if (!$container->hasDefinition($managerId)) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('btn_component.component_manager');

        $managers = array();
        $manager = $container->getDefinition($managerId);

        if ($taggedServices) {
            foreach ($taggedServices as $id => $tagAttributes) {
                foreach ($tagAttributes as $attributes) {
                    $componentManager = $container->getDefinition($id);
                    $componentManager->addMethodCall('setType', array($attributes['type']));
                    $manager->addMethodCall('registerComponentManager', array(new Reference($id), $attributes['type']));
                    $managers[$attributes['type']] = $id;
                }
            }
        }
        $container->setParameter('btn_component.component_managers', $managers);
    }
}
