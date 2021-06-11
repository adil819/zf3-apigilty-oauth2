<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RoomEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $roomMapper    = $container->get('User\Mapper\Room');
        $roomHydrator  = $container->get('HydratorManager')->get('User\Hydrator\Room');
        $roomEventConfig   = $container->get('Config')['user']['photo'];
        $roomEventListener = new RoomEventListener($roomMapper, $roomHydrator, $roomEventConfig);
        $roomEventListener->setLogger($container->get("logger_default"));
        return $roomEventListener;
    }
}
