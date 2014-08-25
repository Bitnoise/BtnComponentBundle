<?php

namespace Btn\ComponentBundle\Provider;

use Btn\ComponentBundle\Model\ContainerInterface;
use Btn\ComponentBundle\Model\StaticContainer;
use Btn\BaseBundle\Provider\EntityProviderInterface;

class ContainerProvider implements ContainerProviderInterface
{
    /** @var \Btn\BaseBundle\Provider\EntityProviderInterface $entityProvider */
    protected $entityProvider;
    /** @var \Btn\ComponentBundle\Model\ContainerInterface[] $containers */
    protected $containers;
    /** @var bolean $loaded has containers been loaded from database */
    private $loaded;

    /**
     *
     */
    public function __construct(EntityProviderInterface $entityProvider)
    {
        $this->entityProvider = $entityProvider;
    }

    /**
     *
     */
    public function getContainerRepository()
    {
        return $this->entityProvider->getRepository();
    }

    /**
     *
     */
    public function setContainers(array $containers)
    {
        // clear containers list
        $this->containers = array();

        foreach ($containers as $container) {
            if (is_array($container)) {
                $container = StaticContainer::createFromArray($container);
            }
            $this->registerContainer($container);
        }

        return $this;
    }

    /**
     *
     */
    public function getContainers()
    {
        if (!$this->loaded) {
            $this->loadContainers();
        }

        return $this->containers;
    }

    /**
     *
     */
    public function registerContainer(ContainerInterface $container)
    {
        $this->containers[$container->getId()] = $container;
    }

    /**
     *
     */
    public function isContainerExists($id)
    {
        $containers = $this->getContainers();

        return isset($containers[$id]) ? true : false;
    }

    /**
     *
     */
    public function getContainerById($id)
    {
        return $this->getContainerRepository()->findOneById($id);
    }

    /**
     *
     */
    public function getContainer($id)
    {
        if ($id instanceof ContainerInterface) {
            return $id;
        }

        if ($this->isContainerExists($id)) {
            $containers = $this->getContainers();

            return $containers[$id];
        }

        return false;
    }

    /**
     *
     */
    public function getContainerClass()
    {
        return $this->entityProvider->getClass();
    }

    /**
     *
     */
    public function createContainer()
    {
        return $this->entityProvider->create();
    }

    /**
     *
     */
    private function loadContainers()
    {
        if ($this->getContainerClass()) {
            $containers = $this->getContainerRepository()->findAll();
            if ($containers) {
                foreach ($containers as $container) {
                    $this->registerContainer($container);
                }
            }
        }

        $this->loaded = true;
    }
}
