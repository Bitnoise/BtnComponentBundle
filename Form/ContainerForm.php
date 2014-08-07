<?php

namespace Btn\WebplatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContainerForm extends AbstractType
{
    /**
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => 'btn_webplatform.container.title',
            ))
            ->add('save', $options['data']->getId() ? 'btn_save' : 'btn_create');
        ;
    }

    public function getName()
    {
        return 'btn_webplatform_form_container';
    }
}
