<?php

namespace Btn\ComponentBundle\Provider;

interface ComponentProviderInterface
{
    public function getComponentRepository();
    public function getComponentById($id, $readonly = true);
    public function getComponent($name, $container, $position, $readonly = true);
    public function getComponentsForContainer($container, $readonly = true);
    public function getComponentClass();
    public function createComponent();
}
