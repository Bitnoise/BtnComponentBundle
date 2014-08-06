<?php

namespace Btn\WebplatformBundle\Hydrator;

use Btn\WebplatformBundle\Model\HydratableInterface;
use Doctrine\ORM\EntityManager;

interface HydratorInterface
{
    public function setEntityManager(EntityManager $em);
    public function registerComponentHydrator(ComponentHydratorInterface $componentHydrator, $alias);
    public function getComponentHydrator($alias);
    public function hydrate(HydratableInterface $object);
    public function dry(HydratableInterface $object);
}
