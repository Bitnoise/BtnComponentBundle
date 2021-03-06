<?php

namespace Btn\ComponentBundle\Manager;

use Btn\ComponentBundle\Model\ComponentInterface;
use Btn\ComponentBundle\Model\ContainerInterface;
use Doctrine\ORM\EntityManager;

class AbstractComponentManager implements ComponentManagerInterface
{
    /** @var \Doctrine\ORM\EntityManager $em */
    protected $em;

    /** @var string type from service tag */
    protected $type;

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
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     *
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     */
    public function getComponentParametersForm(ComponentInterface $component, ContainerInterface $container = null)
    {
    }

    /**
     *
     */
    public function saveComponent(ComponentInterface $component, $andFlush = true)
    {
        if (!$component->getId()) {
            $this->em->persist($component);
        }

        if ($andFlush) {
            $this->em->flush($component);
        }
    }

    /**
     *
     */
    public function deleteComponent(ComponentInterface $component, $andFlush = true)
    {
        $this->em->remove($component);

        if ($andFlush) {
            $this->em->flush();
        }
    }
}
