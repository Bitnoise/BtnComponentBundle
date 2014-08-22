<?php

namespace Btn\ComponentBundle\Form\Type;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TemplateNodeContentProviderType extends AbstractType
{
    /**
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template', 'btn_template')
        ;
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_component_form_type_template_content_provider';
    }
}
