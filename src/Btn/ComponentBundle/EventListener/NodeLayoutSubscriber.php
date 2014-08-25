<?php

namespace Btn\ComponentBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Btn\ComponentBundle\Manager\LayoutManagerInterface;
use Btn\BaseBundle\Provider\EntityProviderInterface;
use Btn\NodeBundle\NodeEvents;
use Btn\NodeBundle\Event\NodeEvent;

class NodeLayoutSubscriber implements EventSubscriberInterface
{
    /** @var \Btn\ComponentBundle\Manager\LayoutManagerInterface $layoutManager */
    protected $layoutManager;
    /** @var \Btn\ComponentBundle\Provider\EntityProviderInterface $componentProvider */
    protected $containerProvider;
    /** @var \Btn\ComponentBundle\Provider\EntityProviderInterface $nodeProvider */
    protected $nodeProvider;

    /**
     *
     */
    public function __construct(
        LayoutManagerInterface $layoutManager,
        EntityProviderInterface $containerProvider,
        EntityProviderInterface $nodeProvider
    ) {
        $this->layoutManager   = $layoutManager;
        $this->containerProvider = $containerProvider;
        $this->nodeProvider      = $nodeProvider;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            NodeEvents::NODE_CREATED      => array('processNodeEvent', 0),
            NodeEvents::PROVIDER_CHANGED  => array('processNodeEvent', 0),
            NodeEvents::PROVIDER_MODIFIED => array('processNodeEvent', 0),
            NodeEvents::NODE_DELETED      => array('processNodeEvent', 0),
        );
    }

    /**
     *
     */
    public function processNodeEvent(NodeEvent $event)
    {
        $node = $event->getNode();

        if ('btn_component.provider.layout_node_content' === $node->getProviderId()) {
            $providerParameters = $node->getProviderParameters();

            // get current containers
            $currentContainers = isset($providerParameters['containers']) ? $providerParameters['containers'] : array();

            // clear current containers
            $containers = array();

            if (!empty($providerParameters['layout'])) {
                $containerBlocks = $this->layoutManager->getTemplateContainerBlocks($providerParameters['layout']);
                foreach (array_keys($containerBlocks) as $block) {
                    if (empty($currentContainers[$block])) {
                        // create container for block and set it as parameter
                        $container = $this->containerProvider->create();
                        $this->containerProvider->save($container);
                        $containers[$block] = $container->getId();
                    }
                }
            }

            $providerParameters['containers'] = $containers;

            $node->setProviderParameters($providerParameters);
            $this->nodeProvider->save($node);
        }
    }
}
