<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;

interface ComponentManagerInterface
{
    public function getParametersForm();
    public function setType($type);
    public function getType();
    public function save(ComponentInterface $component);
}
