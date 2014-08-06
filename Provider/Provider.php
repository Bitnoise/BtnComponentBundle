<?php

namespace Btn\WebplatformBundle\Provider;

class Provider implements ProviderInterface, ContainerProviderInterface, ComponentProviderInterface
{
    /** @var \Btn\WebplatformBundle\Provider\ContainerProviderInterface */
    private $containerProvider;

    /** @var \Btn\WebplatformBundle\Provider\ComponentProviderInterface */
    private $componentProvider;

    /**
     * {@inheritDoc}
     */
    public function __construct(ContainerProviderInterface $containerProvider, ComponentProviderInterface $componentProvider)
    {
        $this->containerProvider = $containerProvider;
        $this->componentProvider = $componentProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function getComponentById($id, $readonly = true)
    {
        return $this->componentProvider->getComponentById($id, $readonly);
    }

    /**
     * {@inheritDoc}
     */
    public function getComponent($type, $container, $position, $readonly = true)
    {
        return $this->componentProvider->getComponent($type, $container, $position, $readonly);
    }

    /**
     * {@inheritDoc}
     */
    public function getComponentsForContainer($container, $readonly = true)
    {
        return $this->componentProvider->getComponentsForContainer($container, $readonly);
    }

    /**
     * {@inheritDoc}
     */
    public function setContainers(array $containers)
    {
        return $this->containerProvider->setContainers($containers);
    }

    /**
     * {@inheritDoc}
     */
    public function getContainers()
    {
        return $this->containerProvider->getContainers();
    }

    /**
     * {@inheritDoc}
     */
    public function registerContainer(array $container, $alias = null)
    {
        return $this->containerProvider->registerContainer($container, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function isContainerExists($container)
    {
        return $this->containerProvider->isContainerExists($container);
    }

    /**
     * {@inheritDoc}
     */
    public function getContainer($container)
    {
        return $this->containerProvider->getContainer($container);
    }
}
