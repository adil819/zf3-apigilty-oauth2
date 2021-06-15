<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class VehicleEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $vehicleMapper    = $container->get('User\Mapper\Vehicle');
        $vehicleHydrator  = $container->get('HydratorManager')->get('User\Hydrator\Vehicle');
        
        $vehicleEventListener = new VehicleEventListener($vehicleMapper);
        $vehicleEventListener->setLogger($container->get("logger_default"));
        $vehicleEventListener->setVehicleHydrator($vehicleHydrator);
        return $vehicleEventListener;
    }
}
