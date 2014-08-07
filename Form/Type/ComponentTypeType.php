<?php

namespace Btn\WebplatformBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Btn\WebplatformBundle\Manager\ManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class ComponentTypeType extends AbstractType
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
        // ldd($builder, $options);
    }

    /**
     *
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $manager = $this->manager;

        $choiceList = function (Options $options) use ($manager) {
            $list = array();

            foreach ($manager->getComponents() as $component) {
                $list[$component['name']] = $component['title'] ? $component['title'] : $component['name'];
            }

            if ($options['container']) {
                $parameters = $options['container']->getParameters();

                if (isset($parameters['avalible_components']) && is_array($parameters['avalible_components'])) {
                    foreach ($list as $name => $title) {
                        if (!in_array($name, $parameters['avalible_components'])) {
                            unset($list[$name]);
                        }
                    }
                }
            }

            return new SimpleChoiceList($list);
        };

        $resolver->setDefaults(array(
            'choice_list' => $choiceList,
            'container'   => null,
        ));

        $resolver->setOptional(array(
            'container',
        ));

        $resolver->setAllowedTypes(array(
            'container' => array('null', 'Btn\\WebplatformBundle\\Model\\ContainerInterface'),
        ));
    }

    /**
     *
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_webplatform_type_component_type';
    }
}