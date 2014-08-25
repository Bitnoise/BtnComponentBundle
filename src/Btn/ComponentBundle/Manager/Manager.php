<?php

namespace Btn\ComponentBundle\Manager;

use Btn\ComponentBundle\Model\ComponentInterface;
use Btn\ComponentBundle\Model\ContainerInterface;
use Btn\ComponentBundle\Provider\ProviderInterface;

class Manager implements ManagerInterface
{
    /** @var \Btn\ComponentBundle\Provider\ComponentProviderInterface */
    protected $provider;

    /** @var \Btn\ComponentBundle\Manager\ComponentManagerInterface[] */
    protected $componentManagers = array();

    /** @var \Btn\ComponentBundle\Renderer\ContainerManagerInterface */
    protected $containerManager;

    /** @var array $components */
    protected $components;

    /**
     *
     */
    public function __construct(ProviderInterface $provider, ContainerManagerInterface $containerManager, array $components)
    {
        $this->provider         = $provider;
        $this->containerManager = $containerManager;
        $this->components       = $components;
    }

    /**
     *
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     *
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     *
     */
    public function registerComponentManager(ComponentManagerInterface $componentManager, $type)
    {
        $this->componentManagers[$type] = $componentManager;
    }

    /**
     *
     */
    public function getComponentManager($type)
    {
        if (!isset($this->componentManagers[$type])) {
            throw new \Exception(sprintf('No manager for component %s', $type));
        }

        return $this->componentManagers[$type];
    }

    /**
     *
     */
    public function getComponentParametersForm(ComponentInterface $component, ContainerInterface $container = null)
    {
        $componentManager = $this->getComponentManager($component->getType());

        return $componentManager->getComponentParametersForm($component, $container);
    }

    /**
     *
     */
    public function saveComponent(ComponentInterface $component, $andFlush = true)
    {
        $componentManager = $this->getComponentManager($component->getType());

        return $componentManager->saveComponent($component, $andFlush);
    }

    /**
     *
     */
    public function deleteComponent(ComponentInterface $component, $andFlush = true)
    {
        $componentManager = $this->getComponentManager($component->getType());

        return $componentManager->deleteComponent($component, $andFlush);
    }

    /**
     *
     */
    public function saveContainer(ContainerInterface $container)
    {
        $this->containerManager->saveContainer($container);
    }

    /**
     *
     */
    public function deleteContainer(ContainerInterface $container)
    {
        $this->containerManager->deleteContainer($container);
    }
}
