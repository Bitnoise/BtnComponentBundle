<?php

namespace Btn\ComponentBundle\Model;

abstract class AbstractHydratable implements HydratableInterface
{
    /** @var bool $hydrated  */
    protected $hydrated = false;

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
}
