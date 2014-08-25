<?php

namespace Btn\ComponentBundle\Model;

interface HydratableInterface
{
    public function hydrated();
    public function isHydrated();
    public function dried();
    public function isDried();
}
