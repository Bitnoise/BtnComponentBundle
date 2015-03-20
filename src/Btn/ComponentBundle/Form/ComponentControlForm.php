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
        $container  = $this->manager->getProvider()->getContainer($options['data']->getContainer());
        $manageable = $container->isManageable();
        $editable   = $container->isEditable();

        if (!$manageable && !$editable) {
            $this->disableAddSaveButtonSubscriber();
        }

        parent::buildForm($builder, $options);

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
                        'placeholder' => 'btn_component.component.type.placeholder',
                        'label'       => 'btn_component.component.type.label',
                        'container' => $container,
                    ))
                ;
            }
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
