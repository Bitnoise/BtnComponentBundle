<?php

namespace Btn\WebplatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComponentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['manageable']) {
            $builder
                // ->add('container')
                // ->add('position')
                ->add('visible', 'checkbox', array(
                    'label' => 'component.visible',
                ))
                ->add('save', 'btn_save')
            ;
        }

        if ($options['editable']) {
            $builder
                ->add('parameters', $options['parameters_type'], array(
                    'label' => false,
                ))
                ->add('save', 'btn_save')
            ;
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'manageable',
            'editable',
        ));

        $resolver->setRequired(array(
            'parameters_type',
        ));

        $resolver->setDefaults(array(
            'data_class' => 'Btn\\WebplatformBundle\\Model\\Component',
            'manageable' => false,
            'editable'   => true,
        ));

        $resolver->setAllowedTypes(array(
            'parameters_type' => 'Symfony\\Component\\Form\\FormTypeInterface',
        ));
    }

    public function getName()
    {
        return 'btn_webplatform_component';
    }
}
