<?php

namespace Btn\ComponentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Btn\ComponentBundle\Model\AbstractComponent;

/**
 * @ORM\Entity(repositoryClass="Btn\ControlBundle\Repository\ComponentRepository")
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
     *
     */
    public function getId()
    {
        return $this->id;
    }
}
