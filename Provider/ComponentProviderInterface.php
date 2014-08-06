<?php

namespace Btn\WebplatformBundle\Provider;

interface ComponentProviderInterface
{
    public function getComponentById($id, $readonly = true);
    /**
     * get component based on name, container and position
     * null for container and position are treated as values, not absents of values
     * when container and position is null then component is global
     * when you specify container you also have to specify position
     */
    public function getComponent($name, $container, $position, $readonly = true);
    public function getComponentsForContainer($container, $readonly = true);
    public function getComponentClass();
    public function createComponent();
}
