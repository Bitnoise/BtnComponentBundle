<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;

interface ComponentManagerInterface
{
    public function getParametersForm();
    public function setAlias($alias);
    public function getAlias();
    public function save(ComponentInterface $component);
}
