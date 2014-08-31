<?php

namespace Btn\ComponentBundle\Controller;

use Btn\AdminBundle\Controller\AbstractControlController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/component")
 */
class ComponentControlController extends AbstractControlController
{
    /**
     * @Route("/", name="btn_component_componentcontrol_index")
     */
    public function indexAction()
    {
        return $this->forward('BtnComponentBundle:ContainerControl:index');
    }

    /**
     * @Route("/{containerId}/list", name="btn_component_componentcontrol_list")
     * @Template()
     */
    public function listAction(Request $request, $containerId)
    {
        $this->checkIfContainerExistsOrThrowException($containerId);

        $provider = $this->get('btn_component.provider');

        return array(
            'components' => $provider->getComponentsForContainer($containerId),
            'container'  => $provider->getContainer($containerId),
        );
    }

    /**
     * @Route("/{containerId}/new", name="btn_component_componentcontrol_new", methods={"GET"})
     * @Route("/{containerId}/create", name="btn_component_componentcontrol_create", methods={"POST"})
     * @Template()
     */
    public function createAction(Request $request, $containerId)
    {
        $this->checkIfContainerExistsOrThrowException($containerId);

        $provider  = $this->get('btn_component.provider');
        $container = $provider->getContainer($containerId);

        if (!$container->isManageable()) {
            throw new \Exception(sprintf('Container with id "%s" is not manageable', $container->getId()));
        }

        $entity = $provider->createComponent();
        $entity->setContainer($container);

        $form = $this->createForm('btn_component_form_component', $entity, array(
            'action' => $this->generateUrl(
                'btn_component_componentcontrol_create',
                array('containerId' => $container->getId())
            ),
        ));

        if ($this->get('btn_component.form.handler.component')->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.created');

            return $this->redirect($this->generateUrl(
                'btn_component_componentcontrol_edit',
                array('id' => $entity->getId())
            ));
        }

        return array(
            'form'      => $form->createView(),
            'entity'    => $entity,
            'container' => $container,
        );
    }

    /**
     * @Route("/{id}/edit", name="btn_component_componentcontrol_edit", methods={"GET"})
     * @Route("/{id}/update", name="btn_component_componentcontrol_update", methods={"POST"})
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $provider = $this->get('btn_component.provider');

        $entity = $provider->getComponentById($id, false);
        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Component "%s" was not found', $id));
        }

        $form = $this->createForm('btn_component_form_component', $entity, array(
            'action' => $this->generateUrl('btn_component_componentcontrol_update', array('id' => $id)),
        ));

        if ($this->get('btn_component.form.handler.component')->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.updated');

            return $this->redirect($this->generateUrl('btn_component_componentcontrol_edit', array('id' => $id)));
        }

        return array(
            'form'      => $form->createView(),
            'entity'    => $entity,
            'container' => $provider->getContainer($entity->getContainer()),
        );
    }

    /**
     * @Route("/{id}/delete/{csrf_token}", name="btn_component_componentcontrol_delete")
     */
    public function deleteAction(Request $request, $id, $csrf_token)
    {
        $this->validateCsrfTokenOrThrowException('btn_component_componentcontrol_delete', $csrf_token);

        $provider = $this->get('btn_component.provider');

        $component = $provider->getComponentById($id, false);
        if (!$component) {
            throw $this->createNotFoundException(sprintf('Component "%s" was not found', $id));
        }

        $container = $component->getContainer();

        $manager = $this->get('btn_component.manager');
        $manager->deleteComponent($component);

        $this->setFlash('btn_admin.flash.deleted');

        return $this->redirect($this->generateUrl(
            'btn_component_componentcontrol_list',
            array('containerId' => $container->getId())
        ));
    }

    /**
     *
     */
    protected function checkIfContainerExistsOrThrowException($containerId)
    {
        if (!$this->get('btn_component.provider')->isContainerExists($containerId)) {
            return $this->createNotFoundException(sprintf('Container with id "%s" was not found', $containerId));
        }
    }
}
