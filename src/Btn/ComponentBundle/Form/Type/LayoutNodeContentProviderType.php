<?php

namespace Btn\ComponentBundle\Form\Type;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LayoutNodeContentProviderType extends AbstractType
{
    /**
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('layout', 'btn_component_layout')
        ;
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_component_form_type_layout_content_provider';
    }
}
