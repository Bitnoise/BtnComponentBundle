<?php

namespace Btn\WebplatformBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractComponent implements ComponentInterface, HydratableInterface
{
    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="type", type="string", length=100)
     */
    protected $type;

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
    public function __construct()
    {
    }

    /**
     *
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     *
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     *
     */
    public function getType()
    {
        return $this->type;
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
