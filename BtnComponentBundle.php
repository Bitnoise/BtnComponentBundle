<?php

namespace Btn\ComponentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Btn\ComponentBundle\DependencyInjection\Compiler;

class BtnComponentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Compiler\RendererCompilerPass());
        $container->addCompilerPass(new Compiler\ManagerCompilerPass());
        $container->addCompilerPass(new Compiler\HydratorCompilerPass());
    }
}
