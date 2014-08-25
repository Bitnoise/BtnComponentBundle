<?php

namespace Btn\ComponentBundle\Provider;

use Btn\ComponentBundle\Form\Type\LayoutNodeContentProviderType;
use Btn\NodeBundle\Provider\NodeContentProviderInterface;

class LayoutNodeContentProvider implements NodeContentProviderInterface
{
    protected $configuration;

    /**
     *
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     *
     */
    public function getForm()
    {
        return new LayoutNodeContentProviderType();
    }

    /**
     *
     */
    public function resolveRoute($formData = array())
    {
        return isset($formData['template']) ? $this->configuration['route_name'] : null;
    }

    /**
     *
     */
    public function resolveRouteParameters($formData = array())
    {
        return isset($formData['template']) ? array('template' => $formData['template']) : array();
    }

    /**
     *
     */
    public function resolveControlRoute($formData = array())
    {
        return isset($formData['template']) ? 'btn_component_containercontrol_edit' : null;
    }

    /**
     *
     */
    public function resolveControlRouteParameters($formData = array())
    {
        return isset($formData['template']) ? array('template' => $formData['template']) : array();
    }

    /**
     *
     */
    public function isEnabled()
    {
        return $this->configuration['enabled'];
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_component.layout_node_content_provider.name';
    }
}
