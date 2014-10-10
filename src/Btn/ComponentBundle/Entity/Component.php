<?php

namespace Btn\ComponentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Btn\ComponentBundle\Model\AbstractComponent;

/**
 * @ORM\Entity(repositoryClass="Btn\ComponentBundle\Repository\ComponentRepository")
 * @ORM\Table(name="btn_component", indexes={
 *     @ORM\Index(name="container_idx", columns={"container", "position"}),
 *     @ORM\Index(name="type_idx", columns={"type", "container", "position"}),
 * })
 */
class Component extends AbstractComponent
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Gedmo\SortableGroup()
     * @ORM\Column(name="container_hash", type="bigint")
     */
    protected $containerHash;

    /**
     * @Gedmo\SortablePosition()
     * @ORM\Column(name="position", type="smallint")
     */
    protected $position;

    /**
     *
     */
    public function getId()
    {
        return $this->id;
    }
}
