<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class VehicleUsersEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $vehicleUsersMapper    = $container->get('User\Mapper\VehicleUsers');
        // $vehicleUsersMapper    = $container->get(\User\Mapper\VehicleUsers::class);
        $vehicleUsersHydrator  = $container->get('HydratorManager')->get('User\Hydrator\VehicleUsers');

        $vehicleUsersEventListener = new VehicleUsersEventListener($vehicleUsersMapper);
        $vehicleUsersEventListener->setLogger($container->get("logger_default"));
        $vehicleUsersEventListener->setVehicleUsersHydrator($vehicleUsersHydrator);
        return $vehicleUsersEventListener;
    }
}
