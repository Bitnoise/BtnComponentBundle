<?php

namespace Btn\ComponentBundle\Twig;

use Btn\ComponentBundle\Provider\ProviderInterface;

class ProviderExtension extends \Twig_Extension
{
    /** @var \Btn\ComponentBundle\Provider\ContainerProviderInterface */
    private $provider;

    /**
     *
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array(
            'btn_component_get_component'            => new \Twig_Function_Method($this, 'getComponent'),
            'btn_component_get_component_parameters' => new \Twig_Function_Method($this, 'getComponentParameters'),
            'btn_component_get_container'            => new \Twig_Function_Method($this, 'getContainer'),
            'btn_component_get_container_name'       => new \Twig_Function_Method($this, 'getContainerName'),
            // aliases
            'btn_wp_get_component'                     => new \Twig_Function_Method($this, 'getComponent'),
            'btn_wp_get_component_parameters'          => new \Twig_Function_Method($this, 'getComponentParameters'),
            'btn_wp_get_container'                     => new \Twig_Function_Method($this, 'getContainer'),
            'btn_wp_get_container_name'                => new \Twig_Function_Method($this, 'getContainerName'),
        );
    }

    /**
     *
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('btn_component_get_container_name', array($this, 'getContainerName')),
            // aliases
            new \Twig_SimpleFilter('btn_wp_get_container_name', array($this, 'getContainerName')),
        );
    }

    /**
     *
     */
    public function getComponent($type, $container, $position)
    {
        return $this->provider->getComponent($type, $container, $position);
    }

    /**
     *
     */
    public function getComponentParameters($type, $container, $position)
    {
        $component = $this->provider->getComponent($type, $container, $position);

        return $component ? $component->getParameters() : null;
    }

    /**
     *
     */
    public function getContainer($container)
    {
        return $this->provider->getContainer($container);
    }

    /**
     *
     */
    public function getContainerName($container)
    {
        $container = $this->provider->getContainer($container);
        if ($container && isset($container['name']) ) {
            return $container['name'];
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'btn_component.provider_extension';
    }
}
