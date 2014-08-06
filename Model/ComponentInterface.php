<?php

namespace Btn\WebplatformBundle\Model;

interface ComponentInterface
{
    public function setName($name);
    public function getName();
    public function setContainer($container);
    public function getContainer();
    public function setVisible($visible);
    public function getVisible();
    public function isVisible();
    public function setPosition($position);
    public function getPosition();
    public function setParameters(array $parameters);
    public function getParameters();
}
