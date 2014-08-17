<?php

namespace Btn\ComponentBundle\Twig;

use Btn\ComponentBundle\Renderer\ContainerRendererInterface;
use Btn\ComponentBundle\Renderer\RendererInterface;
use Btn\ComponentBundle\Model\ComponentInterface;
use Btn\ComponentBundle\Provider\ComponentProviderInterface;

class RendererExtension extends \Twig_Extension
{
    /** @var \Btn\ComponentBundle\Renderer\ContainerRendererInterface */
    private $renderer;

    /** @var \Btn\ComponentBundle\Provider\ComponentProviderInterface */
    private $provider;

    /**
     *
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array(
            'btn_container_render'         => new \Twig_Function_Method($this, 'containerRender', array('is_safe' => array('html'))),
            'btn_component_render'         => new \Twig_Function_Method($this, 'componentRender', array('is_safe' => array('html'))),
            'btn_component_get_and_render' => new \Twig_Function_Method($this, 'componentGetAndRender', array('is_safe' => array('html'))),
        );
    }

    /**
     *
     */
    public function containerRender($type, array $containerParameters = null)
    {
        return $this->renderer->containerRender($type, $containerParameters);
    }

    /**
     *
     */
    public function componentRender(ComponentInterface $component)
    {
        return $this->renderer->componentRender($component);
    }

    /**
     *
     */
    public function componentGetAndRender($type, $container, $position, array $containerParameters = null)
    {
        return $this->renderer->componentGetAndRender($type, $container, $position, $containerParameters);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'btn_component.renderer_extension';
    }
}
