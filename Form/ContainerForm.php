<?php

namespace Btn\WebplatformBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContainerForm extends AbstractForm
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
        return 'btn_webplatform_form_container';
    }
}
