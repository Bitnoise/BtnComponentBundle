<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;
use Btn\WebplatformBundle\Model\ContainerInterface;
use Btn\WebplatformBundle\Provider\ComponentProviderInterface;

class Manager implements ManagerInterface
{
    /** @var \Btn\WebplatformBundle\Provider\ComponentProviderInterface */
    protected $componentProvider;

    /** @var \Btn\WebplatformBundle\Renderer\ComponentManagerInterface[] */
    protected $componentManagers = array();

    /**
     *
     */
    public function __construct(ComponentProviderInterface $componentProvider)
    {
        $this->componentProvider = $componentProvider;
    }

    /**
     *
     */
    public function registerComponentManager(ComponentManagerInterface $componentManager, $type)
    {
        $this->componentManagers[$type] = $componentManager;
    }

    /**
     *
     */
    public function getComponentManager($type)
    {
        if (!isset($this->componentManagers[$type])) {
            throw new \Exception(sprintf('No manager for component %s', $type));
        }

        return $this->componentManagers[$type];
    }

    /**
     *
     */
    public function getComponentParametersForm($type)
    {
        if ($type instanceof ComponentInterface) {
            $componentManager = $this->getComponentManager($type->getName());
        } else {
            $componentManager = $this->getComponentManager($type);
        }

        return $componentManager->getParametersForm();
    }

    /**
     *
     */
    public function componentSave(ComponentInterface $component)
    {
        $componentManager = $this->getComponentManager($component->getType());

        return $componentManager->save($component);
    }

    /**
     *
     */
    public function containerSave(ContainerInterface $container)
    {
        //@TODO
    }
}
