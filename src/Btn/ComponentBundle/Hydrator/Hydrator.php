<?php

namespace Btn\ComponentBundle\Hydrator;

use Btn\ComponentBundle\Model\ComponentInterface;
use Btn\ComponentBundle\Model\HydratableInterface;
use Doctrine\ORM\EntityManager;

class Hydrator implements HydratorInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    /** @var \Btn\ComponentBundle\Hydrator\ComponentHydratorInterface[] */
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
    public function registerComponentHydrator(ComponentHydratorInterface $componentHydrator, $type)
    {
        $this->componentHydrators[$type] = $componentHydrator;
    }

    /**
     *
     */
    public function getComponentHydrator($type)
    {
        if (isset($this->componentHydrators[$type])) {
            return $this->componentHydrators[$type];
        }

        return false;
    }

    /**
     *
     */
    public function dry(HydratableInterface $object)
    {
        if ($object instanceof ComponentInterface && $object->isHydrated()) {
            $objectHydrator = $this->getComponentHydrator($object->getType());
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
            $objectHydrator = $this->getComponentHydrator($object->getType());
            if ($objectHydrator) {
                $objectHydrator->setEntityManager($this->em)->hydrate($object);
                $object->hydrated();
            }
        }
    }
}
