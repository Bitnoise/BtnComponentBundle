<?php

namespace Btn\WebplatformBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ManagerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $managerId = $container->getParameter('btn_webplatform.manager_id');

        if (!$container->hasDefinition($managerId)) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('btn_webplatform.component_manager');

        $managers = array();
        $manager = $container->getDefinition($managerId);

        if ($taggedServices) {
            foreach ($taggedServices as $id => $tagAttributes) {
                foreach ($tagAttributes as $attributes) {
                    $componentManager = $container->getDefinition($id);
                    $componentManager->addMethodCall('setAlias', array($attributes['alias']));
                    $manager->addMethodCall('registerComponentManager', array(new Reference($id), $attributes['alias']));
                    $managers[$attributes['alias']] = $id;
                }
            }
        }
        $container->setParameter('btn_webplatform.component_managers', $managers);
    }
}
