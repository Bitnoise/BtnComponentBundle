<?php

namespace Btn\WebplatformBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractContainer implements \ArrayAccess, ContainerInterface, HydratableInterface
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
    protected $hydrated = false;

    /**
     *
     */
    public function __construct()
    {
        $this->setName(substr(md5(uniqid(rand(), true)), 0, 6));
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
    public function __toString()
    {
        return $this->getTitle() ? $this->getTitle() : $this->getName();
    }

    /**
     *
     */
    public static function createFromArray($array)
    {
        $container = new static();

        foreach ($array as $field => $value) {
            $method = 'set' . ucfirst($field);
            $container->$method($value);
        }

        return $container;
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
        return $this->isHydrated() ? false : true;
    }

    /**
     *
     */
    public function dried()
    {
        $this->hydrated = false;

        return $this;
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
            $method = 'get' . ucfirst($offset);

            if (!method_exists($this, $method)) {
                throw new \Exception(sprintf('Method "%s" not exists for "%s"', $method, __CLASS__));
            }

            return $this->$method();
        }

        return null;
    }
}
