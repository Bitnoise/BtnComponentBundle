<?php

namespace Btn\ComponentBundle\Model;

interface ComponentInterface
{
    public function setTitle($title);
    public function getTitle();
    public function setType($type);
    public function getType();
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
