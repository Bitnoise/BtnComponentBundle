<?php

namespace Btn\WebplatformBundle\Provider;

interface ContainerProviderInterface
{
    public function setContainers(array $containers);
    public function getContainers();
    public function registerContainer(array $container, $alias = null);
    public function getContainer($alias);
    public function isContainerExists($alias);
    public function getContainerClass();
    public function createContainer();
}
