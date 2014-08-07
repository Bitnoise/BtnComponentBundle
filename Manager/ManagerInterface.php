<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;

interface ManagerInterface
{
    public function getProvider();
    public function getComponents();
    public function registerComponentManager(ComponentManagerInterface $componentManager, $alias);
    public function getComponentManager($alias);
    public function getComponentParametersForm($alias);
    public function saveComponent(ComponentInterface $component, $andFlush = true);
    public function deleteComponent(ComponentInterface $component, $andFlush = true);
}
