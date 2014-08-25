<?php

namespace Btn\ComponentBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContainerControlForm extends AbstractForm
{
    /**
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('title', null, array(
                'label' => 'btn_component.container.title',
            ))
        ;
    }

    /**
     *
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => $this->manager->getProvider()->getContainerClass(),
        ));
    }

    public function getName()
    {
        return 'btn_component_form_container';
    }
}
