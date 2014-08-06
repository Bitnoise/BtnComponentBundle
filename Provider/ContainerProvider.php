<?php

namespace Btn\WebplatformBundle\Provider;

use Doctrine\ORM\EntityManager;

class ContainerProvider implements ContainerProviderInterface
{
    /** @var string */
    protected $containerClass;
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;
    /** @var \Btn\WebplatformBundle\Model\AbstractContainerRepository $repo */
    protected $repo;
    /** @var array $containers */
    protected $containers;

    /**
     *
     */
    public function __construct($containerClass, EntityManager $em)
    {
        $this->containerClass = $containerClass;
        $this->em             = $em;
        $this->repo           = $em->getRepository($this->containerClass);
    }

    /**
     *
     */
    public function setContainers(array $containers)
    {
        $this->containers = $containers;
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
    public function registerContainer(array $container, $alias = null)
    {
        if (null === $alias) {
            if (!empty($container['alias'])) {
                $alias = $container['alias'];
            } elseif (!empty($container['name'])) {
                $alias = $container['name'];
            }
        }

        if (!$alias) {
            throw new \Exception('Cannot register container without alias');
        }

        $this->containers[$alias] = $container;
    }

    /**
     *
     */
    public function isContainerExists($alias)
    {
        return isset($this->containers[$alias]) ? true : false;
    }

    /**
     *
     */
    public function getContainer($alias)
    {
        if ($this->isContainerExists($alias)) {
            return $this->containers[$alias];
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
