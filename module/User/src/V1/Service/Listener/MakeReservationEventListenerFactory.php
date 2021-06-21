<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class MakeReservationEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $roomUsersMapper    = $container->get('User\Mapper\RoomUsers');
        $roomUsersHydrator  = $container->get('HydratorManager')->get('User\Hydrator\RoomUsers');

        $makeReservationEventListener = new MakeReservationEventListener(
            $roomUsersMapper
        );
        $makeReservationEventListener->setLogger($container->get("logger_default"));
        $makeReservationEventListener->setRoomUsersHydrator($roomUsersHydrator);
        return $makeReservationEventListener;
    }
}
