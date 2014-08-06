<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;

interface ManagerInterface
{
    public function registerComponentManager(ComponentManagerInterface $componentManager, $alias);
    public function getComponentManager($alias);
    public function getComponentParametersForm($alias);
    public function componentSave(ComponentInterface $component);
}
