<?php

namespace Btn\WebplatformBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractContainer implements ContainerInterface, HydratableInterface
{
    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="name", type="string", length=100)
     */
    protected $name;

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
        $this->setName(substr(md5(uniqid(rand(), true)), 0, 6));
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
