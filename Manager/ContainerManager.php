<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ContainerInterface;
use Btn\WebplatformBundle\Model\StaticContainer;
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
