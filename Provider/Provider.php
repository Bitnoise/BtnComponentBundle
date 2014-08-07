<?php

namespace Btn\WebplatformBundle\Provider;

use Btn\WebplatformBundle\Model\ContainerInterface;

class Provider implements ProviderInterface, ContainerProviderInterface, ComponentProviderInterface
{
    /** @var \Btn\WebplatformBundle\Provider\ContainerProviderInterface */
    private $containerProvider;

    /** @var \Btn\WebplatformBundle\Provider\ComponentProviderInterface */
    private $componentProvider;

    /**
     *
     */
    public function __construct(ContainerProviderInterface $containerProvider, ComponentProviderInterface $componentProvider)
    {
        $this->containerProvider = $containerProvider;
        $this->componentProvider = $componentProvider;
    }

    /**
     *
     */
    public function getComponentRepository()
    {
        return $this->componentProvider->getComponentRepository();
    }

    /**
     *
     */
    public function getComponentById($id, $readonly = true)
    {
        return $this->componentProvider->getComponentById($id, $readonly);
    }

    /**
     *
     */
    public function getComponent($type, $container, $position, $readonly = true)
    {
        return $this->componentProvider->getComponent($type, $container, $position, $readonly);
    }

    /**
     *
     */
    public function getComponentsForContainer($container, $readonly = true)
    {
        return $this->componentProvider->getComponentsForContainer($container, $readonly);
    }

    /**
     *
     */
    public function getComponentClass()
    {
        return $this->componentProvider->getComponentClass();
    }

    /**
     *
     */
    public function createComponent()
    {
        return $this->componentProvider->createComponent();
    }

    /**
     *
     */
    public function getContainerRepository()
    {
        return $this->componentProvider->getContainerRepository();
    }

    /**
     *
     */
    public function setContainers(array $containers)
    {
        return $this->containerProvider->setContainers($containers);
    }

    /**
     *
     */
    public function getContainers()
    {
        return $this->containerProvider->getContainers();
    }

    /**
     *
     */
    public function registerContainer(ContainerInterface $container)
    {
        return $this->containerProvider->registerContainer($container);
    }

    /**
     *
     */
    public function isContainerExists($name)
    {
        return $this->containerProvider->isContainerExists($name);
    }

    /**
     *
     */
    public function getContainerById($id)
    {
        return $this->containerProvider->getContainerById($id);
    }

    /**
     *
     */
    public function getContainer($name)
    {
        return $this->containerProvider->getContainer($name);
    }

    /**
     *
     */
    public function getContainerClass()
    {
        return $this->containerProvider->getContainerClass();
    }

    /**
     *
     */
    public function createContainer()
    {
        return $this->containerProvider->createContainer();
    }
}
