<?php

namespace Btn\ComponentBundle\Model;

class StaticContainer extends AbstractContainer
{
    /** @var string $id */
    protected $id;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType(self::TYPE_STATIC);
        $this->setEditable(false);
        $this->setManageable(false);
    }

    /**
     *
     */
    public function setId($id)
    {
        return $this->id = $id;
    }

    /**
     *
     */
    public function getId()
    {
        return $this->id;
    }
}
