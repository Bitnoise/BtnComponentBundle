<?php

namespace Btn\WebplatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Btn\WebplatformBundle\Model\ComponentInterface;

class RendererController extends Controller
{
    /**
     *
     */
    public function renderAction($name, array $componentParameters = null, array $containerParameters = null)
    {
        return new Response($this->get('btn_webplatform.renderer')->render($name, $componentParameters, $containerParameters));
    }

    /**
     *
     */
    public function componentRenderAction(ComponentInterface $component, array $containerParameters = null)
    {
        return new Response($this->get('btn_webplatform.renderer')->componentRender($component, $containerParameters));
    }

    /**
     *
     */
    public function componentGetAndRenderAction($name, $container, $position, array $containerParameters = null)
    {
        return new Response($this->get('btn_webplatform.renderer')->componentGetAndRender($name, $container, $position, $containerParameters));
    }

    /**
     *
     */
    public function containerRenderAction($container, array $containerParameters = null)
    {
        return new Response($this->get('btn_webplatform.renderer')->containerRender($container, $containerParameters));
    }
}
