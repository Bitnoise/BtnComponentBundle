<?php

namespace Btn\WebplatformBundle\Model;

interface HydratableInterface
{
    public function hydrated();
    public function isHydrated();
    public function dried();
    public function isDried();
}
