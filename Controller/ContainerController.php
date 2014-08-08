<?php

namespace Btn\WebplatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Btn\WebplatformBundle\Model\ComponentInterface;

class ContainerController extends Controller
{
    /**
     * @Route("/", name="btn_webplatform_container_show")
     */
    public function renderAction($id)
    {
        return array('id' => $id);
    }
}
