<?php

namespace Btn\ComponentBundle\Form;

use Btn\AdminBundle\Form\AbstractForm as BaseAbstractForm;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Btn\ComponentBundle\Manager\ManagerInterface;

abstract class AbstractForm extends BaseAbstractForm
{
    /** @var \Btn\ComponentBundle\Manager\ManagerInterface $manager */
    protected $manager;

    /**
     *
     */
    public function setManager(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     *
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'validation_groups' => function (FormInterface $form) {
                return array('Default', $form->getData()->getId() ? 'Update' : 'Create');
            },
        ));
    }
}
