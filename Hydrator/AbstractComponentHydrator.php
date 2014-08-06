<?php

namespace Btn\WebplatformBundle\Hydrator;

use Btn\WebplatformBundle\Model\HydratableInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractComponentHydrator implements ComponentHydratorInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /** @var string */
    private $alias;

    /**
     *
     */
    public function setEntityManager(EntityManager $em = null)
    {
        $this->em = $em;

        return $this;
    }

    /**
     *
     */
    public function getEntityManager()
    {
        if (!$this->em) {
            throw new \Exception('Entity manager not injected');
        }

        return $this->em;
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
    abstract public function hydrate(HydratableInterface $component);

    /**
     *
     */
    abstract public function dry(HydratableInterface $component);

    /**
     *
     */
    protected function objectToId($input)
    {
        if (is_object($input) && method_exists($input, 'getId')) {
            return $input->getId();
        } elseif (is_int($input) || is_null($input)) {
            return $input;
        }

        throw new \Exception('Invalid input');
    }

    /**
     *
     */
    protected function objectsToIds($input)
    {
        $output = array();

        foreach ($input as $item) {
            $output[] = $this->objectToId($item);
        }

        return $output;
    }

    /**
     *
     */
    protected function idToObject($input, $className)
    {
        if (is_object($input)) {
            if (method_exists($input, 'getId')) {
                return $input;
            }

            throw new \Exception('Invalid input');
        }

        $repo = $this->getEntityManager()->getRepository($className);

        if (is_int($input)) {
            return $entity = $repo->findOneById($input);
        }

        return null;
    }

    /**
     *
     */
    protected function idsToObjects($input, $className)
    {
        $output = new ArrayCollection();

        foreach ($input as $item) {
            if (($entity = $this->idToObject($item, $className))) {
                $output->add($entity);
            }
        }

        return $output;
    }
}
