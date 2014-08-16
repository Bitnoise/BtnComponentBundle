<?php

namespace Users\Projects\Btn\ComponentBundle\Model;

/**
 * For better times :P
 */
trait HydratableTrait
{
    /**
     *
     */
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
