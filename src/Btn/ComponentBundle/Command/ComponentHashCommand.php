<?php

namespace Btn\ComponentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ComponentHashCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('btn:component:hash')
            ->setDescription('Generate container hash in component entity')
        ;
    }

    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $componentProvider = $this->getContainer()->get('btn_component.provider.component');

        $all = $componentProvider->getRepository()->findAll();

        foreach ($all as $component) {
            $component->generateContainerHash();
            $componentProvider->save($component);
        }
    }
}
