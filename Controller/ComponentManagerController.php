<?php

namespace Btn\WebplatformBundle\Controller;

use Btn\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Btn\WebplatformBundle\Form\ComponentFormType;

/**
 * @Route("/webplatform/componentmanager")
 */
class ComponentManagerController extends BaseController
{
    /**
     * @Route("/{container}/list", name="btn_webplatform_componentmanager_list")
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
     * @Route("/new", name="btn_webplatform_componentmanager_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/{id}/edit", name="btn_webplatform_componentmanager_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $manager  = $this->get('btn_webplatform.manager');
        $provider = $this->get('btn_webplatform.provider');

        $component = $provider ->getComponentById($id, false);
        if (!$component) {
            throw $this->createNotFoundException(sprintf('Component "%s" was not found', $id));
        }

        $container      = $provider->getContainer($component->getContainer());
        $parametersType = $manager->getComponentParametersForm($component->getType());

        $form = $this->createForm(new ComponentFormType(), $component, array(
            'parameters_type' => $parametersType,
            'action'          => $this->generateUrl('btn_webplatform_componentmanager_edit', array('id' => $id)),
            'manageable'      => $container['manageable'],
            'editable'        => $container['editable'],
        ));

        if ($this->get('btn_webplatform.form_handler.component')->handleForm($form, $request)) {
            return $this->redirect($this->generateUrl('btn_webplatform_componentmanager_edit', array('id' => $id)));
        }

        return array(
            'container' => $container,
            'component' => $component,
            'form'      => $form->createView(),
        );
    }

    /**
     * @Route("/{id}/delete/{csrf_token}", name="btn_webplatform_componentmanager_delete")
     */
    public function deleteAction(Request $request, $id, $csrf_token)
    {
        $this->validateCsrfTokenOrThrowException('btn_wp_delete', $csrf_token);

        return array();
    }
}
