<?php

namespace Btn\WebplatformBundle\Controller;

use Btn\AdminBundle\Controller\AbstractControlController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/webplatform/container")
 * @Template()
 */
class ContainerControlController extends AbstractControlController
{
    /**
     * @Route("/", name="btn_webplatform_containercontrol_index")
     */
    public function indexAction()
    {
        $provider = $this->get('btn_webplatform.provider');

        $containers = $provider->getContainers();

        return array(
            'manageable' => $this->container->getParameter('btn_webplatform.container.class') ? true : false,
            'containers' => $containers,
        );
    }

    /**
     * @Route("/new", name="btn_webplatform_containercontrol_new")
     * @Route("/create", name="btn_webplatform_containercontrol_create", methods={"POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $provider = $this->get('btn_webplatform.provider');

        $container = $provider->createContainer();

        $form = $this->createForm('btn_webplatform_form_container', $container, array(
            'action' => $this->generateUrl('btn_webplatform_containercontrol_create'),
        ));

        if ($this->get('btn_webplatform.form_handler.container')->handleForm($form, $request)) {
            return $this->redirect($this->generateUrl('btn_webplatform_containercontrol_edit', array('id' => $form->getData()->getId())));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{id}/edit", name="btn_webplatform_containercontrol_edit")
     * @Route("/{id}/update", name="btn_webplatform_containercontrol_update", methods={"POST"})
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $manager  = $this->get('btn_webplatform.manager');
        $provider = $this->get('btn_webplatform.provider');

        $container = $provider->getContainerById($id);
        if (!$container) {
            throw $this->createNotFoundException(sprintf('Container "%s" was not found', $id));
        }

        $form = $this->createForm('btn_webplatform_form_container', $container, array(
            'action' => $this->generateUrl('btn_webplatform_containercontrol_update', array('id' => $id)),
        ));

        if ($this->get('btn_webplatform.form_handler.container')->handleForm($form, $request)) {
            return $this->redirect($this->generateUrl('btn_webplatform_containercontrol_edit', array('id' => $id)));
        }

        return array(
            'form'      => $form->createView(),
            'container' => $container,
        );
    }

    /**
     * @Route("/{id}/delete/{csrf_token}", name="btn_webplatform_containercontrol_delete")
     */
    public function deleteAction(Request $request, $id, $csrf_token)
    {
        $provider = $this->get('btn_webplatform.provider');

        $this->validateCsrfTokenOrThrowException('btn_webplatform_containercontrol_delete', $csrf_token);

        $container = $provider->getContainerById($id);
        if (!$container) {
            throw $this->createNotFoundException(sprintf('Container "%s" was not found', $id));
        }

        $manager = $this->get('btn_webplatform.manager');
        $manager->deleteContainer($container);

        return $this->redirect($this->generateUrl('btn_webplatform_containercontrol_list'));
    }
}
