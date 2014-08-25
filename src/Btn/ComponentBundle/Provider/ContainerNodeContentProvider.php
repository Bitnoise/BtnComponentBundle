<?php

namespace Btn\ComponentBundle\Provider;

use Btn\ComponentBundle\Form\Type\ContainerNodeContentProviderType;
use Btn\NodeBundle\Provider\NodeContentProviderInterface;

class ContainerNodeContentProvider implements NodeContentProviderInterface
{
    protected $configuration;

    /**
     *
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;

        if (!$this->configuration['enabled']) {
            return false;
        }
    }

    /**
     *
     */
    public function getForm()
    {
        return new ContainerNodeContentProviderType();
    }

    /**
     *
     */
    public function resolveRoute($formData = array())
    {
        return isset($formData['container']) ? $this->configuration['route_name'] : null;
    }

    /**
     *
     */
    public function resolveRouteParameters($formData = array())
    {
        return isset($formData['container']) ? array('id' => $formData['container']) : array();
    }

    /**
     *
     */
    public function resolveControlRoute($formData = array())
    {
        return isset($formData['container']) ? 'btn_component_containercontrol_edit' : null;
    }

    /**
     *
     */
    public function resolveControlRouteParameters($formData = array())
    {
        return isset($formData['container']) ? array('id' => $formData['container']) : array();
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
        return 'btn_component.container_node_content_provider.name';
    }
}
