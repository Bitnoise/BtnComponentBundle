<?php

namespace Btn\ComponentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Btn\ComponentBundle\Model\AbstractContainer;

/**
 * @ORM\Entity()
 * @ORM\Table(name="btn_container")
 */
class Container extends AbstractContainer
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
