<?php

namespace Btn\ComponentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Btn\ComponentBundle\Manager\ManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Btn\ComponentBundle\Provider\ContainerProviderInterface;

class ContainerType extends AbstractType
{
    /** @var \Btn\ComponentBundle\Manager\ManagerInterface $containerProvider */
    protected $containerProvider;

    /**
     *
     */
    public function __construct(ContainerProviderInterface $containerProvider)
    {
        $this->containerProvider = $containerProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = array();

        foreach ($this->containerProvider->getContainers() as $container) {
            $choices[$container->getName()] = $container->getTitle();
        }

        $resolver->setDefaults(array(
            'choices' => $choices,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_container';
    }
}
