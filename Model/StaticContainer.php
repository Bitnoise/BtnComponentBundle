<?php

namespace Btn\ComponentBundle\Model;

class StaticContainer extends AbstractContainer
{
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
}
