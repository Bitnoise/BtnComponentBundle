<?php

namespace Btn\WebplatformBundle\Hydrator;

use Btn\WebplatformBundle\Model\HydratableInterface;
use Doctrine\ORM\EntityManager;

class Hydrator implements HydratorInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    /** @var \Btn\WebplatformBundle\Hydrator\ComponentHydratorInterface[] */
    protected $componentHydrators = array();

    /**
     *
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     *
     */
    public function registerComponentHydrator(ComponentHydratorInterface $componentHydrator, $alias)
    {
        $this->componentHydrators[$alias] = $componentHydrator;
    }

    /**
     *
     */
    public function getComponentHydrator($alias)
    {
        if (isset($this->componentHydrators[$alias])) {
            return $this->componentHydrators[$alias];
        }

        return false;
    }

    /**
     *
     */
    public function dry(HydratableInterface $component)
    {
        if ($component && $component->isHydrated()) {
            $componentHydrator = $this->getComponentHydrator($component->getName());
            if ($componentHydrator) {
                $componentHydrator->setEntityManager($this->em)->dry($component);
                $component->dried();
            }
        }
    }

    /**
     *
     */
    public function hydrate(HydratableInterface $component)
    {
        if ($component && $component->isDried()) {
            $componentHydrator = $this->getComponentHydrator($component->getName());
            if ($componentHydrator) {
                $componentHydrator->setEntityManager($this->em)->hydrate($component);
                $component->hydrated();
            }
        }
    }
}
