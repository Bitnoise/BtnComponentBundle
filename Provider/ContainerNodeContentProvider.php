<?php

namespace Btn\ComponentBundle\Provider;

use Btn\ComponentBundle\Form\ContainerNodeContentProviderForm;
use Btn\NodeBundle\Provider\NodeContentProviderInterface;

class ContainerNodeContentProvider implements NodeContentProviderInterface
{
    protected $renderRouteName;

    /**
     *
     */
    public function __construct($renderRouteName)
    {
        $this->renderRouteName = $renderRouteName;
    }

    /**
     *
     */
    public function getForm()
    {
        return new ContainerNodeContentProviderForm();
    }

    /**
     *
     */
    public function resolveRoute($formData = array())
    {
        return $this->renderRouteName;
    }

    /**
     *
     */
    public function resolveRouteParameters($formData = array())
    {
        return array('id' => $formData['container']);
    }

    /**
     *
     */
    public function resolveControlRoute($formData = array())
    {
        return 'btn_component_containercontrol_edit';
    }

    /**
     *
     */
    public function resolveControlRouteParameters($formData = array())
    {
        return array('id' => $formData['container']);
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_component.container_node_content_provider.name';
    }
}
