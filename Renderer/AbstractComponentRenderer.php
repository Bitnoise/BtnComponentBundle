<?php

namespace Btn\WebplatformBundle\Renderer;

abstract class AbstractComponentRenderer implements ComponentRendererInterface
{
    /** @var \Twig_Environment */
    protected $twig;

    /** @var string type from service tag */
    protected $type;

    /**
     *
     */
    public function __construct(\Twig_Environment $twig = null)
    {
        $this->twig = $twig;
    }

    /**
     *
     */
    public function setType($type)
    {
        $this->type = $type;
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
    protected function templateRender($template, array $parameters = array())
    {
        return $this->twig->render($template, $parameters);
    }
}
