<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;
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
    public function getParametersForm()
    {
    }

    /**
     *
     */
    public function save(ComponentInterface $component)
    {
        if (!$component->getId()) {
            $this->em->persist($component);
        }

        $this->em->flush();
    }
}
