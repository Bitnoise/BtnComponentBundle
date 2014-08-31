<?php

namespace Btn\ComponentBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Btn\ComponentBundle\Model\HydratableInterface;
use Btn\ComponentBundle\Hydrator\HydratorInterface;

class HydratorSubscriber implements EventSubscriber
{
    /** @var \Btn\ComponentBundle\Hydrator\HydratorInterface $hydrator */
    protected $hydrator;

    /**
     *
     */
    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::preFlush    => array('preFlush', 0),
            Events::prePersist  => array('dryEvent', 0),
            Events::preUpdate   => array('dryEvent', 0),
            Events::postPersist => array('hydrateEvent', 0),
            Events::postUpdate  => array('hydrateEvent', 0),
            Events::postLoad    => array('hydrateEvent', 0),
        );
    }

    /**
     *
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        $identityMap = $uow->getIdentityMap();
        foreach ($identityMap as $class => $entities) {
            $metadata = $em->getClassMetadata($class);
            if ($metadata->reflClass->implementsInterface('Btn\\ComponentBundle\\Model\\HydratableInterface')) {
                foreach ($entities as $entity) {
                    $this->dryEntity($entity, $em);
                }
            }
        }
    }

    /**
     *
     */
    public function dryEvent(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof HydratableInterface) {
            $this->dryEntity($entity, $args->getEntityManager());
        }
    }

    /**
     *
     */
    public function hydrateEvent(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof HydratableInterface) {
            $this->hydrateEntity($entity, $args->getEntityManager());
        }
    }

    /**
     *
     */
    protected function hydrateEntity(HydratableInterface $entity, EntityManager $em)
    {
        $this->hydrator->setEntityManager($em)->hydrate($entity);
    }

    /**
     *
     */
    protected function dryEntity(HydratableInterface $entity, EntityManager $em)
    {
        $this->hydrator->setEntityManager($em)->dry($entity);
    }
}
