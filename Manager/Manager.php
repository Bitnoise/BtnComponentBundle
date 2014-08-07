<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;
use Btn\WebplatformBundle\Model\ContainerInterface;
use Btn\WebplatformBundle\Provider\ProviderInterface;

class Manager implements ManagerInterface
{
    /** @var \Btn\WebplatformBundle\Provider\ComponentProviderInterface */
    protected $provider;

    /** @var \Btn\WebplatformBundle\Manager\ComponentManagerInterface[] */
    protected $componentManagers = array();

    /** @var \Btn\WebplatformBundle\Renderer\ContainerManagerInterface */
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
    public function getComponentParametersForm($type)
    {
        if ($type instanceof ComponentInterface) {
            $componentManager = $this->getComponentManager($type->getName());
        } else {
            $componentManager = $this->getComponentManager($type);
        }

        return $componentManager->getComponentParametersForm();
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
