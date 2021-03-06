<?php

namespace Btn\ComponentBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractComponent extends AbstractHydratable implements ComponentInterface
{
    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @Assert\NotBlank(groups={"Create"})
     * @ORM\Column(name="type", type="string", length=100)
     */
    protected $type;

    /**
     * @ORM\Column(name="container", type="string", length=100)
     */
    protected $container;

    /**
     * @ORM\Column(name="container_hash", type="bigint")
     */
    protected $containerHash;

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
    protected $parameters;

    /**
     *
     */
    public function __construct()
    {
        $this->setParameters(array());
        $this->setVisible(true);
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
        if ($container instanceof ContainerInterface) {
            $this->container = $container->getId();
        } elseif (is_string($container)) {
            $this->container = $container;
        } else {
            throw new \Exception('Invalid parameter for setContainer() method');
        }

        $this->generateContainerHash();

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
    public function generateContainerHash()
    {
        $this->setContainerHash(self::generateHash($this->getContainer()));
    }

    /**
     *
     */
    private function setContainerHash($containerHash)
    {
        $this->containerHash = $containerHash;
    }

    /**
     *
     */
    public function getContainerHash()
    {
        return $this->containerHash;
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
    public function isVisible()
    {
        return $this->visible;
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
    public static function generateHash($string)
    {
        return intval(substr(md5($string), 0, 8), 16);
    }
}
