<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ContainerInterface;

interface ContainerManagerInterface
{
    public function saveContainer(ContainerInterface $container, $andFlush = true);
    public function deleteContainer(ContainerInterface $container, $andFlush = true);
}
