<?php

namespace Btn\WebplatformBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Btn\WebplatformBundle\Model\ComponentInterface;

class ComponentSubscriber implements EventSubscriber
{
    protected $componentClass;

    /**
     *
     */
    public function __construct($componentClass)
    {
        $this->componentClass = $componentClass;
    }

    /**
     *
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
        );
    }

    /**
     *
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof ComponentInterface) {
            if (null === $entity->getPosition()) {
                $repo = $args->getEntityManager()->getRepository($this->componentClass);
                $mp   = $repo->getMaxPositionForContainer($entity->getContainer());
                $entity->setPosition($mp + 1);
            }
        }
    }
}
