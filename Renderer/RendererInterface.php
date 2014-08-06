<?php

namespace Btn\WebplatformBundle\Renderer;

use Btn\WebplatformBundle\Model\ComponentInterface;

interface RendererInterface
{
    /**
     *
     */
    public function registerComponentRenderer(ComponentRendererInterface $componentRenderer, $alias);

    /**
     *
     */
    public function getComponentRenderer($alias);

    /**
     *
     */
    public function componentRender(ComponentInterface $component, array $containerParameters = null);

    /**
     *
     */
    public function componentGetAndRender($name, $container, $position, array $containerParameters = null);

    /**
     *
     */
    public function containerRender($container, array $containerParameters = null);

    /**
     *
     */
    public function render($name, array $componentParameters = null, array $containerParameters = null);
}
;
