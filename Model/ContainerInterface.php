<?php

namespace Btn\WebplatformBundle\Model;

interface ContainerInterface
{
    const TYPE_STATIC  = 1;
    const TYPE_DYNAMIC = 2;

    public function setTitle($title);
    public function getTitle();
    public function setName($name);
    public function getName();
    public function setType($type);
    public function getType();
    public function setManageable($manageable);
    public function getManageable();
    public function isManageable();
    public function setEditable($editable);
    public function getEditable();
    public function isEditable();
    public function setParameters(array $parameters);
    public function getParameters();
}
