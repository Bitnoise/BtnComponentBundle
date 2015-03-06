<?php

namespace Btn\ComponentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Btn\ComponentBundle\Manager\ManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class ComponentType extends AbstractType
{
    /** @var \Btn\ComponentBundle\Manager\ManagerInterface $manager */
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
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

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
                        unset($title);
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

        $resolver->setDefined(array(
            'container',
        ));

        $resolver->setAllowedTypes('container', array('null', 'Btn\\ComponentBundle\\Model\\ContainerInterface'));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'btn_select2_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_component';
    }
}
