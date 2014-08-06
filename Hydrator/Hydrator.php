<?php

namespace Btn\WebplatformBundle\Hydrator;

use Btn\WebplatformBundle\Model\ComponentInterface;
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
    public function dry(HydratableInterface $object)
    {
        if ($object instanceof ComponentInterface && $object->isHydrated()) {
            $objectHydrator = $this->getComponentHydrator($object->getName());
            if ($objectHydrator) {
                $objectHydrator->setEntityManager($this->em)->dry($object);
                $object->dried();
            }
        }
    }

    /**
     *
     */
    public function hydrate(HydratableInterface $object)
    {
        if ($object instanceof ComponentInterface && $object->isDried()) {
            $objectHydrator = $this->getComponentHydrator($object->getName());
            if ($objectHydrator) {
                $objectHydrator->setEntityManager($this->em)->hydrate($object);
                $object->hydrated();
            }
        }
    }
}
