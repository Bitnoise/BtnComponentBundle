<?php

namespace Btn\WebplatformBundle\Form;

use Btn\AdminBundle\Form\AbstractForm as AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Btn\WebplatformBundle\Manager\ManagerInterface;

abstract class AbstractForm extends AbstractType
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => function (FormInterface $form) {
                return array('Default', $form->getData()->getId() ? 'Update' : 'Create');
            },
        ));
    }
}
