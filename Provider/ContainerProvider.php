<?php

namespace Btn\WebplatformBundle\Provider;

use Btn\WebplatformBundle\Model\ContainerInterface;
use Btn\WebplatformBundle\Model\StaticContainer;
use Doctrine\ORM\EntityManager;

class ContainerProvider implements ContainerProviderInterface
{
    /** @var string */
    protected $containerClass;
    /** @var \Btn\WebplatformBundle\Model\AbstractContainerRepository $containerRepository */
    protected $containerRepository;
    /** @var \Btn\WebplatformBundle\Model\ContainerInterface[] $containers */
    protected $containers;

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
        return isset($this->containers[$name]) ? true : false;
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
    public function getContainer($name)
    {
        if ($name instanceof ContainerInterface) {
            return $name;
        }

        if ($this->isContainerExists($name)) {
            return $this->containers[$name];
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
}
