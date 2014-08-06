<?php

namespace Btn\WebplatformBundle\Model;

interface ContainerInterface
{
    public function setName($name);
    public function getName();
    public function setParameters(array $parameters);
    public function getParameters();
}
