<?php

namespace Btn\ComponentBundle\Controller;

use Btn\AdminBundle\Controller\AbstractControlController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/container")
 */
class ContainerControlController extends AbstractControlController
{
    /**
     * @Route("/", name="btn_component_containercontrol_index")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'manageable' => $this->container->getParameter('btn_component.container.manageable') ? true : false,
            'pagination' => $this->get('btn_component.provider')->getContainers(),
        );
    }

    /**
     * @Route("/new", name="btn_component_containercontrol_new", methods={"GET"})
     * @Route("/create", name="btn_component_containercontrol_create", methods={"POST"})
     * @Template()
     */
    public function createAction(Request $request)
    {
        $this->checkIfContainersAreManageableOrThrowException();

        $provider = $this->get('btn_component.provider');

        $entity = $provider->createContainer();

        $form = $this->createForm('btn_component_form_container', $entity, array(
            'action' => $this->generateUrl('btn_component_containercontrol_create'),
        ));

        if ($this->get('btn_component.form.handler.container')->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.created');

            return $this->redirect($this->generateUrl(
                'btn_component_containercontrol_edit',
                array('id' => $form->getData()->getId())
            ));
        }

        return array(
            'form'   => $form->createView(),
            'entity' => $entity,
        );
    }

    /**
     * @Route("/{id}/edit", name="btn_component_containercontrol_edit", methods={"GET"})
     * @Route("/{id}/update", name="btn_component_containercontrol_update", methods={"POST"})
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $provider = $this->get('btn_component.provider');

        $entity = $provider->getContainerById($id);
        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Container "%s" was not found', $id));
        }

        $form = $this->createForm('btn_component_form_container', $entity, array(
            'action' => $this->generateUrl('btn_component_containercontrol_update', array('id' => $id)),
        ));

        if ($this->get('btn_component.form.handler.container')->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.updated');

            return $this->redirect($this->generateUrl('btn_component_containercontrol_edit', array('id' => $id)));
        }

        return array(
            'form'   => $form->createView(),
            'entity' => $entity,
        );
    }

    /**
     * @Route("/{id}/delete/{csrf_token}", name="btn_component_containercontrol_delete")
     */
    public function deleteAction(Request $request, $id, $csrf_token)
    {
        $this->checkIfContainersAreManageableOrThrowException();

        $provider = $this->get('btn_component.provider');

        $this->validateCsrfTokenOrThrowException('btn_component_containercontrol_delete', $csrf_token);

        $container = $provider->getContainerById($id);
        if (!$container) {
            throw $this->createNotFoundException(sprintf('Container "%s" was not found', $id));
        }

        $manager = $this->get('btn_component.manager');
        $manager->deleteContainer($container);

        $this->setFlash('btn_admin.flash.deleted');

        return $this->redirect($this->generateUrl('btn_component_containercontrol_index'));
    }

    /**
     *
     */
    protected function checkIfContainersAreManageableOrThrowException()
    {
        if (!$this->container->getParameter('btn_component.container.manageable')) {
            throw $this->createNotFoundException('Containers are not manageable');
        }
    }
}
