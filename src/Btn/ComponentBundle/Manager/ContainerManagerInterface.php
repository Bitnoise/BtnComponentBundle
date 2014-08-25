<?php

namespace Btn\ComponentBundle\Manager;

use Btn\ComponentBundle\Model\ContainerInterface;

interface ContainerManagerInterface
{
    public function saveContainer(ContainerInterface $container, $andFlush = true);
    public function deleteContainer(ContainerInterface $container, $andFlush = true);
}
