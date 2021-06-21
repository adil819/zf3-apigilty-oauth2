<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ActivateRoomEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $roomUsersMapper    = $container->get('User\Mapper\RoomUsers');
        $roomUsersHydrator  = $container->get('HydratorManager')->get('User\Hydrator\RoomUsers');

        $activateRoomEventListener = new ActivateRoomEventListener(
            $roomUsersMapper
        );
        $activateRoomEventListener->setLogger($container->get("logger_default"));
        $activateRoomEventListener->setRoomUsersHydrator($roomUsersHydrator);
        return $activateRoomEventListener;
    }
}
