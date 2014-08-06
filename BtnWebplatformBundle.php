<?php

namespace Btn\WebplatformBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Btn\WebplatformBundle\DependencyInjection\Compiler;

class BtnWebplatformBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Compiler\RendererCompilerPass());
        $container->addCompilerPass(new Compiler\ManagerCompilerPass());
        $container->addCompilerPass(new Compiler\HydratorCompilerPass());
    }
}
