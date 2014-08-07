<?php

namespace Btn\WebplatformBundle\Model;

use Doctrine\ORM\EntityRepository;

abstract class AbstractComponentRepository extends EntityRepository
{
    public function getMaxPositionForContainer($container)
    {
        $qb = $this->createQueryBuilder('component');

        $qb
            ->select('MAX(component.position)')
            ->where('component.container = :container')
            ->setParameter('container', $container);

        $q = $qb->getQuery();

        return (int) $q->getSingleScalarResult();
    }
}
