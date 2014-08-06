<?php

namespace Btn\WebplatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContainerFormType extends AbstractType
{
    protected $containers;

    /**
     *
     */
    public function __construct(array $containers = null)
    {
        $this->containers = $containers;
    }

    /**
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('container')
            // ->add('position')
            ->add('parameters', $options['parameters_type'])
            ->add('save', 'submit', array(
                'label' => 'Save',
            ))
        ;
    }

    public function getName()
    {
        return 'btn_webplatform_container';
    }
}
