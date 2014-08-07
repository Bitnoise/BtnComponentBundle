<?php

namespace Btn\WebplatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Btn\WebplatformBundle\Manager\ManagerInterface;

class ComponentForm extends AbstractType
{
    /** @var \Btn\WebplatformBundle\Manager\ManagerInterface $manager */
    protected $manager;

    /**
     *
     */
    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $container  = $this->manager->getProvider()->getContainer($options['data']->getContainer());
        $manageable = $container->isManageable();
        $editable   = $container->isEditable();

        if ($manageable) {
            $builder
                ->add('title', null, array(
                    'label' => 'btn_webplatform.component.title',
                ))
                ->add('visible', 'checkbox', array(
                    'label' => 'btn_webplatform.component.visible',
                ))
            ;
        }

        if ($editable) {
            if ($options['data']->getType()) {
                $parametersType = $this->manager->getComponentParametersForm($options['data']->getType());
                if ($parametersType) {
                    $builder
                        ->add('parameters', $parametersType, array(
                            'label' => false,
                        ))
                    ;
                }
            } else {
                $builder
                    ->add('type', 'btn_webplatform_type_component_type', array(
                        'label'     => 'btn_webplatform.component.type',
                        'container' => $container,
                    ))
                ;
            }
        }

        if ($manageable || $editable) {
            $builder->add('save', $options['data']->getId() ? 'btn_save' : 'btn_create');
        }
    }

    /**
     *
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_webplatform_form_component';
    }
}
