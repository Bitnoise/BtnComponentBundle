<?php

namespace Btn\WebplatformBundle\Provider;

class ContainerProvider implements ContainerProviderInterface
{
    /** @var array $containers */
    protected $containers = array();

    /**
     *
     */
    public function __construct(array $containers = null)
    {
        if ($containers) {
            $this->setContainers($containers);
        }
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
}
