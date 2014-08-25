<?php

namespace Btn\ComponentBundle\View;

class ComponentView
{
    /** @var string $type type of component */
    protected $type;

    /** @var string $content rendered html from component */
    protected $content;

    /**
     *
     */
    public function __construct($type, $content)
    {
        $this->type    = $type;
        $this->content = $content;
    }

    /**
     *
     */
    public function getType()
    {
        return $this->type;
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
