<?php

namespace Btn\ComponentBundle\Manager;

use Btn\ComponentBundle\Model\ComponentInterface;
use Btn\ComponentBundle\Model\ContainerInterface;

interface ComponentManagerInterface
{
    public function getComponentParametersForm(ComponentInterface $component, ContainerInterface $container = null);
    public function setType($type);
    public function getType();
    public function saveComponent(ComponentInterface $component, $andFlush = true);
    public function deleteComponent(ComponentInterface $component, $andFlush = true);
}
