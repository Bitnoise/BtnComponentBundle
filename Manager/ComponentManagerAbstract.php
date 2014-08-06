<?php

namespace Btn\WebplatformBundle\Manager;

use Btn\WebplatformBundle\Model\ComponentInterface;
use Doctrine\ORM\EntityManager;

class ComponentManagerAbstract implements ComponentManagerInterface
{
    /** @var \Doctrine\ORM\EntityManager $em */
    protected $em;

    /** @var string alias from service tag */
    protected $alias;

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
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     *
     */
    public function getAlias()
    {
        return $this->alias;
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
