<?php

namespace Btn\ComponentBundle\Manager;

class LayoutManager implements LayoutManagerInterface
{
    protected $twig;
    protected $layouts;

    /**
     *
     */
    public function __construct(\Twig_Environment $twig, array $layouts)
    {
        $this->twig      = $twig;
        $this->layouts = $layouts;
    }

    /**
     *
     */
    public function has($layout)
    {
        return isset($this->layouts[$layout]) ? true : false;
    }

    /**
     *
     */
    public function getConfig($layout)
    {
        if ($this->has($layout)) {
            return $this->layouts[$layout];
        }

        throw new \Exception(sprintf('Template "%s" is missing', $layout));
    }

    /**
     *
     */
    public function getTemplateBlocks($layout)
    {
        $config = $this->getConfig($layout);

        return $this->twig->loadTemplate($config['template'])->getBlocks();
    }

    /**
     *
     */
    public function getTemplateContainerBlocks($layout)
    {
        $blocks = array();

        foreach ($this->getTemplateBlocks($layout) as $key => $block) {
            if (preg_match(('~^container\_~'), $key)) {
                $blocks[$key] = $block;
            }
        }

        return $blocks;
    }
}
