<?php

namespace Btn\ComponentBundle\Model;

interface AvalibleComponentsInterface
{
    /**
     * Returns list of component names that should be allowed to add
     * @return array|null
     */
    public function getAvalibleComponents();
}
