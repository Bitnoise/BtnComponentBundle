<?php

namespace Btn\ComponentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContainerNodeContentProviderForm extends AbstractType
{
    /**
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('container', 'btn_container')
        ;
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_component_form_node_content_provider';
    }
}
