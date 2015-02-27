<?php

namespace Btn\ComponentBundle\Form\Type;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LayoutType extends AbstractType
{
    /** @var array $layouts */
    protected $layouts;

    /**
     *
     */
    public function __construct(array $layouts = null)
    {
        $this->layouts = $layouts;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $choices = array();

        if ($this->layouts) {
            foreach ($this->layouts as $key => $template) {
                $choices[$key] = !empty($template['title']) ? $template['title'] : $template['template'];
            }
        }

        $resolver->setDefaults(array(
            'label'       => 'btn_component.type.layout.label',
            'placeholder' => 'btn_component.type.layout.placeholder',
            'choices'     => $choices,
            'expanded'    => false,
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
        return 'btn_component_layout';
    }
}
