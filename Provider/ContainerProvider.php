<?php

namespace Btn\ComponentBundle\Provider;

use Btn\ComponentBundle\Model\ContainerInterface;
use Btn\ComponentBundle\Model\StaticContainer;
use Doctrine\ORM\EntityManager;

class ContainerProvider implements ContainerProviderInterface
{
    /** @var string */
    protected $containerClass;
    /** @var \Btn\ComponentBundle\Model\AbstractContainerRepository $containerRepository */
    protected $containerRepository;
    /** @var \Btn\ComponentBundle\Model\ContainerInterface[] $containers */
    protected $containers;
    /** @var bolean $loaded has containers been loaded from database */
    private $loaded;

    /**
     *
     */
    public function __construct($containerClass, EntityManager $em)
    {
        $this->containerClass      = $containerClass;
        $this->containerRepository = $this->containerClass ? $em->getRepository($this->containerClass) : null;
    }

    /**
     *
     */
    public function getContainerRepository()
    {
        if (!$this->containerRepository) {
            throw new \Exception('Container class not defined');
        }

        return $this->containerRepository;
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
        $this->containers[$container->getName()] = $container;
    }

    /**
     *
     */
    public function isContainerExists($name)
    {
        $containers = $this->getContainers();

        return isset($containers[$name]) ? true : false;
    }

    /**
     *
     */
    public function getContainerByIdentifier($identifier)
    {
        return is_numeric($identifier) ? $this->getContainerRepository()->findOneById($identifier) : $this->getContainerRepository()->findOneByName($identifier);
    }

    /**
     *
     */
    public function getContainer($name)
    {
        if ($name instanceof ContainerInterface) {
            return $name;
        }

        if ($this->isContainerExists($name)) {
            $containers = $this->getContainers();

            return $containers[$name];
        }

        return false;
    }

    /**
     *
     */
    public function getContainerClass()
    {
        return $this->containerClass;
    }

    /**
     *
     */
    public function createContainer()
    {
        $containerClass = $this->getContainerClass();
        $container = new $containerClass();

        return $container;
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
