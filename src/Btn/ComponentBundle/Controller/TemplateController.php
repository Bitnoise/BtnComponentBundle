<?php

namespace Btn\ComponentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TemplateController extends Controller
{
    /**
     * @Route("/_container/{template}", name="btn_component_template_show")
     */
    public function showAction($template)
    {
        return array('template' => $template);
    }
}
