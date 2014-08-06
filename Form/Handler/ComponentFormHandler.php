<?php

namespace Btn\WebplatformBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Btn\WebplatformBundle\Manager\ManagerInterface;

class ComponentFormHandler
{
    /** @var \Btn\WebplatformBundle\Manager\ManagerInterface $manager */
    private $manager;

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
    public function handleForm(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->componentSave($form->getData());

            return true;
        }
    }
}
