<?php

namespace Btn\ComponentBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
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
            Events::preFlush,
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
    public function __call($method, $arguments)
    {
        if (preg_match('~^pre(Persist|Update)$~', $method)) {
            $this->dryEvent($arguments[0]);
        } elseif (preg_match('~^post(Persist|Update|Load)$~', $method)) {
            $this->hydrateEvent($arguments[0]);
        } else {
            throw new \BadMethodCallException();
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
