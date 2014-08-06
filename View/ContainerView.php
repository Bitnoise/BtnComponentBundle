<?php

namespace Btn\WebplatformBundle\View;

class ContainerView implements \Iterator
{
    /** @var \Btn\WebplatformBundle\View\ComponentView[] */
    protected $componentViews;

    /**
     *
     */
    public function addComponentView(ComponentView $componentView)
    {
        $this->componentViews[] = $componentView;
    }

    /**
     *
     */
    public function removeComponentView($key)
    {
        if (isset($this->componentViews[$key])) {
            unset($this->componentViews[$key]);

            return true;
        }
    }

    /**
     *
     */
    public function __toString()
    {
        $content = '';

        if ($this->componentViews) {
            foreach ($this->componentViews as $componentView) {
                $content .= (string) $componentView;
            }
        }

        return $content;
    }

    /**
     * \Iterator method
     */
    public function rewind()
    {
        reset($this->componentViews);
    }

    /**
     * \Iterator method
     */
    public function current()
    {
        return current($this->componentViews);
    }

    /**
     * \Iterator method
     */
    public function key()
    {
        return key($this->componentViews);
    }

    /**
     * \Iterator method
     */
    public function next()
    {
        return next($this->componentViews);
    }

    /**
     * \Iterator method
     */
    public function valid()
    {
        $key = key($this->componentViews);

        return (null !== $key && false !==  $key);
    }
}
