<?php

namespace Btn\ComponentBundle\Form\Type;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContainerNodeContentProviderType extends AbstractType
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
        return 'btn_component_form_node_template_content_provider';
    }
}
