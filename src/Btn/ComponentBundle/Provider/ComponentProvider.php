<?php

namespace Btn\ComponentBundle\Provider;

use Doctrine\ORM\EntityManager;

class ComponentProvider implements ComponentProviderInterface
{
    /** @var string */
    protected $componentClass;
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;
    /** @var \Btn\ComponentBundle\Model\AbstractComponentRepository $componentRepository */
    protected $componentRepository;

    /**
     *
     */
    public function __construct($componentClass, EntityManager $em)
    {
        $this->componentClass      = $componentClass;
        $this->em                  = $em;
        $this->componentRepository = $em->getRepository($this->componentClass);
    }

    /**
     *
     */
    public function getComponentRepository()
    {
        return $this->componentRepository;
    }

    /**
     *
     */
    public function getComponentById($id, $readonly = true)
    {
        $component = $this->componentRepository->find($id);

        if ($readonly && $component) {
            $this->em->detach($component);
        }

        return $component;
    }

    /**
     *
     */
    public function getComponent($type, $container, $position, $readonly = true)
    {
        $component = $this->componentRepository->findOneBy(
            array('type' => $type, 'container' => $container, 'position' => $position)
        );

        if ($readonly && $component) {
            $this->em->detach($component);
        }

        return $component;
    }

    /**
     *
     */
    public function getComponentsForContainer($container, $readonly = true)
    {
        $components = $this->componentRepository->findByContainer($container, array('position' => 'ASC'));
        if ($readonly && $components) {
            foreach ($components as $component) {
                $this->em->detach($component);
            }
        }

        return $components;
    }

    /**
     *
     */
    public function getComponentClass()
    {
        return $this->componentClass;
    }

    /**
     *
     */
    public function createComponent()
    {
        $componentClass = $this->getComponentClass();
        $component = new $componentClass();

        return $component;
    }
}
