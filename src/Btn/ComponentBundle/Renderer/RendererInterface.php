<?php

namespace Btn\ComponentBundle\Renderer;

use Btn\ComponentBundle\Model\ComponentInterface;

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
