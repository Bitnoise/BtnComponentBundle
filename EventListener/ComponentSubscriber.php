<?php

namespace Btn\ComponentBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Btn\ComponentBundle\Model\ComponentInterface;

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
