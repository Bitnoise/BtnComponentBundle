<?php

namespace Btn\ComponentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ContainerController extends Controller
{
    /**
     * @Route("/_container/{id}", name="btn_component_container_show")
     */
    public function showAction($id)
    {
        return array('id' => $id);
    }
}
