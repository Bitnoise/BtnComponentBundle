<?php

namespace Btn\WebplatformBundle\Hydrator;

use Btn\WebplatformBundle\Model\HydratableInterface;
use Doctrine\ORM\EntityManager;

interface HydratorInterface
{
    public function setEntityManager(EntityManager $em);
    public function registerComponentHydrator(ComponentHydratorInterface $componentHydrator, $alias);
    public function getComponentHydrator($alias);
    public function hydrate(HydratableInterface $component);
    public function dry(HydratableInterface $component);
}
