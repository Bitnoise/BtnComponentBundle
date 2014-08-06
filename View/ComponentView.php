<?php

namespace Btn\WebplatformBundle\View;

class ComponentView
{
    /** @var string $name name of component */
    protected $name;

    /** @var string $content rendered html from component */
    protected $content;

    /**
     *
     */
    public function __construct($name, $content)
    {
        $this->name    = $name;
        $this->content = $content;
    }

    /**
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->getContent();
    }
}
