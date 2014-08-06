<?php

namespace Btn\WebplatformBundle\Renderer;

interface ComponentRendererInterface
{
    /**
     * Renders component based on parameters and returns html
     *
     * @param  array  $parameters parameters for redner
     * @return string rendered html
     */
    public function render(array $componentParameters = array(), array $containerParameters = null);

    /**
     *
     */
    public function setAlias($alias);

    /**
     *
     */
    public function getAlias();
}
