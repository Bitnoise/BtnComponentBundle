<?php

namespace Btn\WebplatformBundle\Renderer;

use Btn\WebplatformBundle\Provider\ProviderInterface;
use Btn\WebplatformBundle\Model\ComponentInterface;
use Btn\WebplatformBundle\View\ComponentView;
use Btn\WebplatformBundle\View\ContainerView;

class Renderer implements RendererInterface
{
    /** @var \Btn\WebplatformBundle\Provider\ProviderInterface */
    protected $provider;

    /** @var \Btn\WebplatformBundle\Renderer\ComponentRendererInterface[] */
    protected $componentRenderers = array();

    /**
     *
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     *
     */
    public function registerComponentRenderer(ComponentRendererInterface $componentRenderer, $alias)
    {
        $this->componentRenderers[$alias] = $componentRenderer;
    }

    /**
     *
     */
    public function getComponentRenderer($alias)
    {
        if (!isset($this->componentRenderers[$alias])) {
            throw new \Exception(sprintf('No renderer for component %s', $alias));
        }

        return $this->componentRenderers[$alias];
    }

    /**
     *
     */
    public function render($name, array $componentParameters = null, array $containerParameters = null)
    {
        $renderer = $this->getComponentRenderer($name);

        return new ComponentView($name, $renderer->render($componentParameters ?: array(), $containerParameters));
    }

    /**
     *
     */
    public function componentRender(ComponentInterface $component, array $containerParameters = null)
    {
        return $this->render($component->getName(), $component->getParameters(), $containerParameters);
    }

    /**
     *
     */
    public function componentGetAndRender($name, $container, $position, array $containerParameters = null)
    {
        $component = $this->provider->getComponent($name, $container, $position, true);

        return $this->componentRender($component, $containerParameters);
    }

    /**
     *
     */
    public function containerRender($container, array $containerParameters = null)
    {
        $components = $this->provider->getComponentsForContainer($container);

        $containerView = new ContainerView();

        if ($components) {
            foreach ($components as $component) {
                if ($component->isVisible()) {
                    $containerView->addComponentView($this->componentRender($component, $containerParameters));
                }
            }
        }

        return $containerView;
    }
}
