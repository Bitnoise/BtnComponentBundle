<?php

namespace Btn\WebplatformBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Btn\WebplatformBundle\Manager\ManagerInterface;

class ContainerFormHandler
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
            $this->manager->saveContainer($form->getData());

            return true;
        }
    }
}
