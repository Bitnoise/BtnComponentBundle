<?php

namespace Btn\WebplatformBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Btn\WebplatformBundle\Model\HydratableInterface;
use Btn\WebplatformBundle\Hydrator\HydratorInterface;

class HydratorSubscriber implements EventSubscriber
{
    /** @var \Btn\WebplatformBundle\Hydrator\HydratorInterface $hydrator */
    protected $hydrator;

    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     *
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::preFlush,
            // Events::onFlush,
            // Events::postFlush,
            Events::prePersist,
            Events::preUpdate,
            Events::postPersist,
            Events::postUpdate,
            Events::postLoad,
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
            if ($metadata->reflClass->implementsInterface('Btn\\WebplatformBundle\\Model\\HydratableInterface')) {
                foreach ($entities as $entity) {
                    $this->dryEntity($entity, $em);
                }
            }
        }
    }

    /**
     *
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof HydratableInterface) {
                $this->dryEntity($entity, $em);
            }
        }
    }

    /**
     *
     */
    public function postFlush(PostFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof HydratableInterface) {
                $this->hydrateEntity($entity, $em);
            }
        }
    }

    /**
     *
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->dryEvent($args);
    }

    /**
     *
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->dryEvent($args);
    }

    /**
     *
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->hydrateEvent($args);
    }

    /**
     *
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->hydrateEvent($args);
    }

    /**
     *
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $this->hydrateEvent($args);
    }

    /**
     *
     */
    protected function hydrateEvent(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof HydratableInterface) {
            $this->hydrateEntity($entity, $args->getEntityManager());
        }
    }

    /**
     *
     */
    protected function dryEvent(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof HydratableInterface) {
            $this->dryEntity($entity, $args->getEntityManager());
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
