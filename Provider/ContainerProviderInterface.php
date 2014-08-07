<?php

namespace Btn\WebplatformBundle\Provider;

use Btn\WebplatformBundle\Model\ContainerInterface;

interface ContainerProviderInterface
{
    public function getContainerRepository();
    public function setContainers(array $containers);
    public function getContainers();
    public function registerContainer(ContainerInterface $container);
    public function getContainerById($id);
    public function getContainer($name);
    public function isContainerExists($name);
    public function getContainerClass();
    public function createContainer();
}
