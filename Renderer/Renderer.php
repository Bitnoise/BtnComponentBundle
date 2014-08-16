<?php

namespace Btn\ComponentBundle\Renderer;

use Btn\ComponentBundle\Provider\ProviderInterface;
use Btn\ComponentBundle\Model\ComponentInterface;
use Btn\ComponentBundle\View\ComponentView;
use Btn\ComponentBundle\View\ContainerView;

class Renderer implements RendererInterface
{
    /** @var \Btn\ComponentBundle\Provider\ProviderInterface */
    protected $provider;

    /** @var \Btn\ComponentBundle\Renderer\ComponentRendererInterface[] */
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
    public function registerComponentRenderer(ComponentRendererInterface $componentRenderer, $type)
    {
        $this->componentRenderers[$type] = $componentRenderer;
    }

    /**
     *
     */
    public function getComponentRenderer($type)
    {
        if (!isset($this->componentRenderers[$type])) {
            throw new \Exception(sprintf('No renderer for component %s', $type));
        }

        return $this->componentRenderers[$type];
    }

    /**
     *
     */
    public function render($type, array $componentParameters = null, array $containerParameters = null)
    {
        $renderer = $this->getComponentRenderer($type);

        return new ComponentView($type, $renderer->render($componentParameters ?: array(), $containerParameters));
    }

    /**
     *
     */
    public function componentRender(ComponentInterface $component, array $containerParameters = null)
    {
        return $this->render($component->getType(), $component->getParameters(), $containerParameters);
    }

    /**
     *
     */
    public function componentGetAndRender($type, $container, $position, array $containerParameters = null)
    {
        $component = $this->provider->getComponent($type, $container, $position, true);

        return $component ? $this->componentRender($component, $containerParameters) : null;
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
