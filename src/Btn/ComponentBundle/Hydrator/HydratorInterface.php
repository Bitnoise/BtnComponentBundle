<?php

namespace Btn\ComponentBundle\Hydrator;

use Btn\ComponentBundle\Model\HydratableInterface;
use Doctrine\ORM\EntityManager;

interface HydratorInterface
{
    public function setEntityManager(EntityManager $em);
    public function registerComponentHydrator(ComponentHydratorInterface $componentHydrator, $type);
    public function getComponentHydrator($type);
    public function hydrate(HydratableInterface $object);
    public function dry(HydratableInterface $object);
}
