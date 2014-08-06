<?php

namespace Btn\WebplatformBundle\Provider;

interface ContainerProviderInterface
{
    public function setContainers(array $containers);
    public function addContainer(array $container);
    public function getContainer($container);
    public function isContainerExists($container);
}
