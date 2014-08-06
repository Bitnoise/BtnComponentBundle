<?php

namespace Btn\WebplatformBundle\Provider;

use Doctrine\ORM\EntityManager;

class ComponentProvider implements ComponentProviderInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;
    /** @var string */
    protected $entityClass;

    /**
     *
     */
    public function __construct(EntityManager $em, $entityClass)
    {
        $this->em          = $em;
        $this->entityClass = $entityClass;
        $this->repo        = $em->getRepository($this->entityClass);
    }

    /**
     *
     */
    public function getComponentById($id, $readonly = true)
    {
        $component = $this->repo->find($id);

        if ($readonly && $component) {
            $this->em->detach($component);
        }

        return $component;
    }

    /**
     * {@inheritDoc}
     */
    public function getComponent($type, $container, $position, $readonly = true)
    {
        $component = $this->repo->findOneBy(array('type' => $type, 'container' => $container, 'position' =>$position));

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
        $components = $this->repo->findByContainer($container, array('position' => 'ASC'));
        if ($readonly && $components) {
            foreach ($components as $component) {
                $this->em->detach($component);
            }
        }

        return $components;
    }
}
