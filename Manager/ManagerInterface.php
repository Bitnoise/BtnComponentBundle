<?php

namespace Btn\ComponentBundle\Manager;

use Btn\ComponentBundle\Model\ContainerInterface;
use Btn\ComponentBundle\Model\ComponentInterface;

interface ManagerInterface
{
    public function getProvider();
    public function getComponents();
    public function registerComponentManager(ComponentManagerInterface $componentManager, $alias);
    public function getComponentManager($alias);
    public function getComponentParametersForm(ComponentInterface $component, ContainerInterface $container = null);
    public function saveComponent(ComponentInterface $component, $andFlush = true);
    public function deleteComponent(ComponentInterface $component, $andFlush = true);
}
