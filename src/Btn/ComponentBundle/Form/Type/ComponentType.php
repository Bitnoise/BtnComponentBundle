<?php

namespace Btn\ComponentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Btn\ComponentBundle\Manager\ManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Btn\ComponentBundle\Model\AvalibleComponentsInterface;

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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $manager = $this->manager;

        $choiceList = function (Options $options) use ($manager) {
            $list = array();

            foreach ($manager->getComponents() as $component) {
                $list[$component['name']] = $component['title'] ? $component['title'] : $component['name'];
            }

            if ($options['container']) {
                $parameters = $options['container']->getParameters();
                $avalibleComponents = null;

                if (isset($parameters['avalible_components'])) {
                    $avalibleComponents = $parameters['avalible_components'];
                }

                if ($options['container'] instanceof AvalibleComponentsInterface) {
                    $avalibleComponents = $options['container']->getAvalibleComponents();
                }

                if (is_array($avalibleComponents)) {
                    foreach ($list as $name => $title) {
                        unset($title);
                        if (!in_array($name, $avalibleComponents)) {
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
            'container' => array('null', 'Btn\\ComponentBundle\\Model\\ContainerInterface'),
        ));
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
