<?php

namespace Btn\ComponentBundle\Form\Type;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateType extends AbstractType
{
    /** @var array $templates */
    protected $templates;

    /**
     *
     */
    public function __construct(array $templates = null)
    {
        $this->templates = $templates;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $choices = array();

        if ($this->templates) {
            foreach ($this->templates as $key => $template) {
                $choices[$key] = !empty($template['title']) ? $template['title'] : $template['template'];
            }
        }

        $resolver->setDefaults(array(
            'label'       => 'btn_component.type.template.label',
            'empty_value' => 'btn_component.type.template.empty_value',
            'choices'     => $choices,
            'expanded'    => false,
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
        return 'btn_template';
    }
}
