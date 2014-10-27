<?php

namespace Btn\ComponentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Btn\ComponentBundle\Model\ComponentInterface;

class RendererController extends Controller
{
    /**
     *
     */
    public function renderAction($name, array $componentParameters = null, array $containerParameters = null)
    {
        return new Response(
            $this->get('btn_component.renderer')->render($name, $componentParameters, $containerParameters)
        );
    }

    /**
     *
     */
    public function componentRenderAction(ComponentInterface $component, array $containerParameters = null)
    {
        return new Response(
            $this->get('btn_component.renderer')->componentRender($component, $containerParameters)
        );
    }

    /**
     *
     */
    public function componentGetAndRenderAction($name, $container, $position, array $containerParameters = null)
    {
        return new Response(
            $this->get('btn_component.renderer')
                ->componentGetAndRender($name, $container, $position, $containerParameters)
        );
    }

    /**
     *
     */
    public function containerRenderAction($container, array $containerParameters = null)
    {
        return new Response(
            $this->get('btn_component.renderer')->containerRender($container, $containerParameters)
        );
    }
}
