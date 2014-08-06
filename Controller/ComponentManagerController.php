<?php

namespace Btn\WebplatformBundle\Controller;

use Btn\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Btn\WebplatformBundle\Form\ComponentType;

/**
 * @Route("/webplatform/componentmanager")
 */
class ComponentManagerController extends BaseController
{

    /**
     * @Route("/", name="btn_webplatform_componentmanager_index")
     */
    public function indexAction()
    {
        $containers = $this->container->getParameter('btn_webplatform.containers');

        return $this->render($this->container->getParameter('btn_webplatform.control.component_manager.index_template'), array(
            'containers' => $containers,
        ));
    }

    /**
     * @Route("/{container}/list", name="btn_webplatform_componentmanager_list")
     */
    public function listAction(Request $request, $container)
    {
        $provider = $this->get('btn_webplatform.provider');

        if (!$provider->isContainerExists($container)) {
            return $this->createNotFoundException(sprintf('Container "%s" was not found', $container));
        }

        return $this->render($this->container->getParameter('btn_webplatform.control.component_manager.list_template'), array(
            'components' => $provider->getComponentsForContainer($container),
            'container'  => $provider->getContainer($container),
        ));
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
        $parametersType = $manager->getComponentParametersForm($component->getName());

        $form = $this->createForm(new ComponentType(), $component, array(
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
