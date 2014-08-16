<?php

namespace Btn\ComponentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NodeContentType extends AbstractType
{

    private $data;

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('container', 'choice', array('choices' => $this->data))
        ;
    }

    public function getName()
    {
        return 'btn_nodesbundle_routecontent';
    }
}
