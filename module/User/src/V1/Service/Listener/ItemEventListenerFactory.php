<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ItemEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $itemMapper    = $container->get('User\Mapper\Item');
        $itemHydrator  = $container->get('HydratorManager')->get('User\Hydrator\Item');

        $itemEventListener = new ItemEventListener($itemMapper);
        $itemEventListener->setLogger($container->get("logger_default"));
        $itemEventListener->setItemHydrator($itemHydrator);
        return $itemEventListener;
    }
}
