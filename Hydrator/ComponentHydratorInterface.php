<?php

namespace Btn\WebplatformBundle\Hydrator;

use Btn\WebplatformBundle\Model\HydratableInterface;
use Doctrine\ORM\EntityManager;

interface ComponentHydratorInterface
{
    public function setEntityManager(EntityManager $em = null);
    public function setType($type);
    public function getType();
    public function hydrate(HydratableInterface $component);
    public function dry(HydratableInterface $component);
}
