<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RoomUsersEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $roomUsersMapper    = $container->get('User\Mapper\RoomUsers');
        // $roomUsersMapper    = $container->get(\User\Mapper\RoomUsers::class);
        $roomUsersHydrator  = $container->get('HydratorManager')->get('User\Hydrator\RoomUsers');
        
        $roomUsersEventListener = new RoomUsersEventListener($roomUsersMapper);
        $roomUsersEventListener->setLogger($container->get("logger_default"));
        $roomUsersEventListener->setRoomUsersHydrator($roomUsersHydrator);
        return $roomUsersEventListener;
    }
}
