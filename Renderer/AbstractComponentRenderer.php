<?php

namespace Btn\WebplatformBundle\Renderer;

abstract class AbstractComponentRenderer implements ComponentRendererInterface
{
    /** @var \Twig_Environment */
    protected $twig;

    /** @var string alias from service tag */
    protected $alias;

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
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     *
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     *
     */
    protected function templateRender($template, array $parameters = array())
    {
        return $this->twig->render($template, $parameters);
    }
}
