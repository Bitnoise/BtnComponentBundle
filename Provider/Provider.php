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
    public function getComponent($name, $container, $position, $readonly = true)
    {
        return $this->componentProvider->getComponent($name, $container, $position, $readonly);
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
    public function addContainer(array $container)
    {
        return $this->containerProvider->addContainer($container);
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
