<?php

namespace Btn\ComponentBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractContainer extends AbstractHydratable implements \ArrayAccess, ContainerInterface
{
    /**
     * @Assert\NotBlank(groups={"Create", "Update"})
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="type", type="smallint")
     */
    protected $type;

    /**
     * @ORM\Column(name="manageable", type="boolean")
     */
    protected $manageable;

    /**
     * @ORM\Column(name="editable", type="boolean")
     */
    protected $editable;

    /**
     * @ORM\Column(name="parameters", type="array")
     */
    protected $parameters = array();

    /**
     *
     */
    public function __construct()
    {
        $this->setType(self::TYPE_DYNAMIC);
        $this->setEditable(true);
        $this->setmanageable(true);
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
    public function setManageable($manageable)
    {
        $this->manageable = $manageable;

        return $this;
    }

    /**
     *
     */
    public function getManageable()
    {
        return $this->manageable;
    }

    /**
     *
     */
    public function isManageable()
    {
        return $this->getManageable();
    }

    /**
     *
     */
    public function setEditable($editable)
    {
        $this->editable = $editable;

        return $this;
    }

    /**
     *
     */
    public function getEditable()
    {
        return $this->editable;
    }

    /**
     *
     */
    public function isEditable()
    {
        return $this->getEditable();
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
    public function isDynamic()
    {
        return (self::TYPE_DYNAMIC === $this->getType()) ? true : false;
    }

    /**
     *
     */
    public function isStatic()
    {
        return (self::TYPE_STATIC === $this->getType()) ? true : false;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->getTitle() ? $this->getTitle() : $this->getId();
    }

    /**
     *
     */
    public static function createFromArray($array)
    {
        $container = new static();

        foreach ($array as $field => $value) {
            $method = 'set'.ucfirst($field);
            if (method_exists($container, $method)) {
                $container->$method($value);
            }
        }

        return $container;
    }

    /**
     * \ArrayAccess method
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception('Setting not allowd via array access');
    }

    /**
     * \ArrayAccess method
     */
    public function offsetUnset($offset)
    {
        throw new \Exception('Unsetting not allowd via array access');
    }

    /**
     * \ArrayAccess method
     */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset) ? true : false;
    }

    /**
     * \ArrayAccess method
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            $method = 'get'.ucfirst($offset);

            if (!method_exists($this, $method)) {
                throw new \Exception(sprintf('Method "%s" not exists for "%s"', $method, __CLASS__));
            }

            return $this->$method();
        }

        return null;
    }
}
