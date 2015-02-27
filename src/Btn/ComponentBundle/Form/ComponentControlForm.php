<?php

namespace Btn\ComponentBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComponentControlForm extends AbstractForm
{
    /**
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->disableAddSaveButtonSubscriber();

        parent::buildForm($builder, $options);

        $container  = $this->manager->getProvider()->getContainer($options['data']->getContainer());
        $manageable = $container->isManageable();
        $editable   = $container->isEditable();

        $builder
            ->add('title', null, array(
                'label' => 'btn_component.component.title',
            ))
            ->add('visible', 'checkbox', array(
                'label' => 'btn_component.component.visible',
            ))
        ;

        if ($editable) {
            if ($options['data']->getType()) {
                $parametersType = $this->manager->getComponentParametersForm($options['data'], $container);
                if ($parametersType) {
                    $builder
                        ->add('parameters', $parametersType, array(
                            'label' => false,
                        ))
                    ;
                }
            } else {
                $builder
                    ->add('type', 'btn_component', array(
                        'empty_value' => 'btn_component.component.type.empty_value',
                        'label'       => 'btn_component.component.type',
                        'container' => $container,
                    ))
                ;
            }
        }

        if ($manageable || $editable) {
            $builder->add('save', $options['data']->getId() ? 'btn_update' : 'btn_create');
        }
    }

    /**
     *
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => $this->manager->getProvider()->getComponentClass(),
        ));
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_component_form_component';
    }
}
