<?php

namespace Btn\WebplatformBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Component implements ComponentInterface, HydratableInterface
{
    /**
     * @ORM\Column(name="name", type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(name="container", type="string", length=100)
     */
    protected $container;

    /**
     * @ORM\Column(name="position", type="smallint")
     */
    protected $position;

    /**
     * @ORM\Column(name="visible", type="boolean")
     */
    protected $visible;

    /**
     * @ORM\Column(name="parameters", type="array")
     */
    protected $parameters = array();

    /**
     *
     */
    protected $hydrated = false;

    /**
     *
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     *
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     *
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     *
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     *
     */
    public function isVisible()
    {
        return $this->getVisible();
    }

    /**
     *
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     *
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     *
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     *
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     *
     */
    public function isHydrated()
    {
        return $this->hydrated;
    }

    /**
     *
     */
    public function hydrated()
    {
        $this->hydrated = true;

        return $this;
    }

    /**
     *
     */
    public function isDried()
    {
        return !$this->hydrated;
    }

    /**
     *
     */
    public function dried()
    {
        $this->hydrated = false;

        return $this;
    }
}
