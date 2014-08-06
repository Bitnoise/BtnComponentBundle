<?php

namespace Btn\WebplatformBundle\Controller;

use Btn\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Btn\WebplatformBundle\Form\ContainerFormType;

/**
 * @Route("/webplatform/containertmanager")
 */
class ContainerManagerController extends BaseController
{
    /**
     * @Route("/", name="btn_webplatform_containermanager_index")
     */
    public function indexAction()
    {
        $provider = $this->get('btn_webplatform.provider');

        $containers = $provider->getContainers();

        return $this->render($this->container->getParameter('btn_webplatform.control.container_manager.index_template'), array(
            'containers' => $containers,
        ));
    }
}
