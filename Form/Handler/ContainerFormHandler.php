<?php

namespace Btn\ComponentBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Btn\ComponentBundle\Manager\ManagerInterface;

class ContainerFormHandler
{
    /** @var \Btn\ComponentBundle\Manager\ManagerInterface $manager */
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
            $this->manager->saveContainer($form->getData());

            return true;
        }
    }
}
