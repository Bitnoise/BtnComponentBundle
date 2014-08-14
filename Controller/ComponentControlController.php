<?php

namespace Btn\WebplatformBundle\Controller;

use Btn\AdminBundle\Controller\AbstractControlController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/webplatform/component")
 */
class ComponentControlController extends AbstractControlController
{
    /**
     * @Route("/", name="btn_webplatform_componentcontrol_index")
     */
    public function indexAction()
    {
        return $this->forward('BtnWebplatformBundle:ContainerControl:index');
    }

    /**
     * @Route("/{container}/list", name="btn_webplatform_componentcontrol_list")
     * @Template()
     */
    public function listAction(Request $request, $container)
    {
        $provider = $this->get('btn_webplatform.provider');

        if (!$provider->isContainerExists($container)) {
            return $this->createNotFoundException(sprintf('Container "%s" was not found', $container));
        }

        return array(
            'components' => $provider->getComponentsForContainer($container),
            'container'  => $provider->getContainer($container),
        );
    }

    /**
     * @Route("/{container}/new", name="btn_webplatform_componentcontrol_new")
     * @Route("/{container}/create", name="btn_webplatform_componentcontrol_create", methods={"POST"})
     * @Template()
     */
    public function newAction(Request $request, $container)
    {
        $provider = $this->get('btn_webplatform.provider');

        if (!$provider->isContainerExists($container)) {
            return $this->createNotFoundException(sprintf('Container "%s" was not found', $container));
        }

        // WARNING! override key with whole container for ease of use
        $container = $provider->getContainer($container);

        if (!$container->isManageable()) {
            throw new \Exception(sprintf('Container "%s" is not manageable', $container->getName()));
        }

        $component = $provider->createComponent();
        $component->setContainer($container);

        $form = $this->createForm('btn_webplatform_form_component', $component, array(
            'action' => $this->generateUrl('btn_webplatform_componentcontrol_create', array('container' => $container->getName())),
        ));

        if ($this->get('btn_webplatform.form_handler.component')->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.created');

            return $this->redirect($this->generateUrl('btn_webplatform_componentcontrol_edit', array('id' => $form->getData()->getId())));
        }

        return array(
            'container' => $container,
            'form'      => $form->createView(),
            'component' => $component,
        );
    }

    /**
     * @Route("/{id}/edit", name="btn_webplatform_componentcontrol_edit")
     * @Route("/{id}/update", name="btn_webplatform_componentcontrol_update", methods={"POST"})
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $manager  = $this->get('btn_webplatform.manager');
        $provider = $this->get('btn_webplatform.provider');

        $component = $provider->getComponentById($id, false);
        if (!$component) {
            throw $this->createNotFoundException(sprintf('Component "%s" was not found', $id));
        }

        $form = $this->createForm('btn_webplatform_form_component', $component, array(
            'action' => $this->generateUrl('btn_webplatform_componentcontrol_update', array('id' => $id)),
        ));

        if ($this->get('btn_webplatform.form_handler.component')->handleForm($form, $request)) {
            $this->setFlash('btn_admin.flash.updated');

            return $this->redirect($this->generateUrl('btn_webplatform_componentcontrol_edit', array('id' => $id)));
        }

        return array(
            'container' => $provider->getContainer($component->getContainer()),
            'form'      => $form->createView(),
            'component' => $component,
        );
    }

    /**
     * @Route("/{id}/delete/{csrf_token}", name="btn_webplatform_componentcontrol_delete")
     */
    public function deleteAction(Request $request, $id, $csrf_token)
    {
        $provider = $this->get('btn_webplatform.provider');

        $this->validateCsrfTokenOrThrowException('btn_webplatform_componentcontrol_delete', $csrf_token);

        $component = $provider->getComponentById($id, false);
        if (!$component) {
            throw $this->createNotFoundException(sprintf('Component "%s" was not found', $id));
        }

        $container = $component->getContainer();

        $manager = $this->get('btn_webplatform.manager');
        $manager->deleteComponent($component);

        $this->setFlash('btn_admin.flash.deleted');

        return $this->redirect($this->generateUrl('btn_webplatform_componentcontrol_list', array('container' => $container)));
    }
}
