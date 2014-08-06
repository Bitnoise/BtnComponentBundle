<?php

namespace Btn\WebplatformBundle\Twig;

use Btn\WebplatformBundle\Renderer\ContainerRendererInterface;
use Btn\WebplatformBundle\Renderer\RendererInterface;
use Btn\WebplatformBundle\Model\ComponentInterface;
use Btn\WebplatformBundle\Provider\ComponentProviderInterface;

class RendererExtension extends \Twig_Extension
{
    /** @var \Btn\WebplatformBundle\Renderer\ContainerRendererInterface */
    private $renderer;

    /** @var \Btn\WebplatformBundle\Provider\ComponentProviderInterface */
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
            'btn_webplatform_container_render'         => new \Twig_Function_Method($this, 'containerRender', array('is_safe' => array('html'))),
            'btn_webplatform_component_render'         => new \Twig_Function_Method($this, 'componentRender', array('is_safe' => array('html'))),
            'btn_webplatform_component_get_and_render' => new \Twig_Function_Method($this, 'componentGetAndRender', array('is_safe' => array('html'))),
            'btn_webplatform_render'                   => new \Twig_Function_Method($this, 'render', array('is_safe' => array('html'))),
            // aliases
            'btn_wp_container_render'         => new \Twig_Function_Method($this, 'containerRender', array('is_safe' => array('html'))),
            'btn_wp_component_render'         => new \Twig_Function_Method($this, 'componentRender', array('is_safe' => array('html'))),
            'btn_wp_component_get_and_render' => new \Twig_Function_Method($this, 'componentGetAndRender', array('is_safe' => array('html'))),
            'btn_wp_render'                   => new \Twig_Function_Method($this, 'render', array('is_safe' => array('html'))),
        );
    }

    /**
     *
     */
    public function containerRender($name, array $containerParameters = null)
    {
        return $this->renderer->containerRender($name, $containerParameters);
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
    public function componentGetAndRender($name, $container, $position, array $containerParameters = null)
    {
        return $this->renderer->componentGetAndRender($name, $container, $position, $containerParameters);
    }

    /**
     *
     */
    public function render($name, $parameters = null)
    {
        return $this->renderer->render($name, $parameters);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'btn_webplatform.renderer_extension';
    }
}
