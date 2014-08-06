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
    public function addContainer(array $container)
    {
        $this->containers[] = $container;
    }

    /**
     *
     */
    public function isContainerExists($container)
    {
        return isset($this->containers[$container]) ? true : false;
    }

    /**
     *
     */
    public function getContainer($container)
    {
        if ($this->isContainerExists($container)) {
            return $this->containers[$container];
        }

        return false;
    }
}
