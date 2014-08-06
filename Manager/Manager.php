<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;
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
    public function registerComponentManager(ComponentManagerInterface $componentManager, $alias)
    {
        $this->componentManagers[$alias] = $componentManager;
    }

    /**
     *
     */
    public function getComponentManager($alias)
    {
        if (!isset($this->componentManagers[$alias])) {
            throw new \Exception(sprintf('No manager for component %s', $alias));
        }

        return $this->componentManagers[$alias];
    }

    /**
     *
     */
    public function getComponentParametersForm($alias)
    {
        if ($alias instanceof ComponentInterface) {
            $componentManager = $this->getComponentManager($alias->getName());
        } else {
            $componentManager = $this->getComponentManager($alias);
        }

        return $componentManager->getParametersForm();
    }

    /**
     *
     */
    public function componentSave(ComponentInterface $component)
    {
        $componentManager = $this->getComponentManager($component->getName());

        return $componentManager->save($component);
    }
}
