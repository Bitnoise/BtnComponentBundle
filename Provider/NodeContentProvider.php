<?php

namespace Btn\ComponentBundle\Provider;

use Btn\ComponentBundle\Form\Type\NodeContentType;
use Btn\NodesBundle\Provider\NodeContentProviderInterface;

/**
 *
 */
class NodeContentProvider implements NodeContentProviderInterface
{
    private $containersProvider;
    private $renderRouteName;

    public function __construct($containersProvider, $renderRouteName)
    {
        $this->containersProvider = $containersProvider;
        $this->renderRouteName    = $renderRouteName;
    }

    public function getForm()
    {
        $data = array();
        foreach ($this->containersProvider->getContainers() as $container) {
            $data[$container->getName()] = $container->getTitle();
        }

        return new NodeContentType($data);
    }

    public function resolveRoute($formData = array())
    {
        return $this->renderRouteName;
    }

    public function resolveRouteParameters($formData = array())
    {
        return array('id' => $formData['container']);
    }

    public function resolveControlRoute($formData = array())
    {
        return 'btn_component_containercontrol_edit';
    }

    public function resolveControlRouteParameters($formData = array())
    {
        return array('id' => $formData['container']);
    }

    public function getName()
    {
        return 'Page components';
    }
}
