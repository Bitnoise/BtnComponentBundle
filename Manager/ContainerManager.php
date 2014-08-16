<?php

namespace Btn\ComponentBundle\Manager;

use Btn\ComponentBundle\Model\ContainerInterface;
use Btn\ComponentBundle\Model\StaticContainer;
use Doctrine\ORM\EntityManager;

class ContainerManager implements ContainerManagerInterface
{
    /** @var \Doctrine\ORM\EntityManager $em */
    protected $em;

    /**
     *
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     *
     */
    public function saveContainer(ContainerInterface $container, $andFlush = true)
    {
        if ($container instanceof StaticContainer) {
            throw new \Exception('Static containers cannot be saved');
        }

        if (!$container->getId()) {
            $this->em->persist($container);
        }

        if ($andFlush) {
            $this->em->flush($container);
        }
    }

    /**
     *
     */
    public function deleteContainer(ContainerInterface $container, $andFlush = true)
    {
        if ($container instanceof StaticContainer) {
            throw new \Exception('Static containers cannot be deleted');
        }

        $this->em->remove($container);

        if ($andFlush) {
            $this->em->flush($container);
        }
    }
}
