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
