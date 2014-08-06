<?php

namespace Btn\WebplatformBundle\Renderer;

use Btn\WebplatformBundle\Model\ComponentInterface;

interface RendererInterface
{
    /**
     *
     */
    public function registerComponentRenderer(ComponentRendererInterface $componentRenderer, $type);

    /**
     *
     */
    public function getComponentRenderer($type);

    /**
     *
     */
    public function componentRender(ComponentInterface $component, array $containerParameters = null);

    /**
     *
     */
    public function componentGetAndRender($type, $container, $position, array $containerParameters = null);

    /**
     *
     */
    public function containerRender($container, array $containerParameters = null);

    /**
     *
     */
    public function render($type, array $componentParameters = null, array $containerParameters = null);
}
;
