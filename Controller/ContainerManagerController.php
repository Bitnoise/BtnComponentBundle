<?php

namespace Btn\WebplatformBundle\Controller;

use Btn\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Btn\WebplatformBundle\Form\ContainerFormType;

/**
 * @Route("/webplatform/containertmanager")
 * @Template()
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

        return array(
            'containers' => $containers,
        );
    }

    /**
     * @Route("/new", name="btn_webplatform_containermanager_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $form = new ContainerFormType();
    }
}
