<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;

interface ComponentManagerInterface
{
    public function getComponentParametersForm();
    public function setType($type);
    public function getType();
    public function saveComponent(ComponentInterface $component, $andFlush = true);
    public function deleteComponent(ComponentInterface $component, $andFlush = true);
}
