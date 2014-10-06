<?php

namespace Btn\ComponentBundle\Model;

use Gedmo\Sortable\Entity\Repository\SortableRepository;

abstract class AbstractComponentRepository extends SortableRepository
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
