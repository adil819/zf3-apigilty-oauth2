<?php
namespace User\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class VehicleUsersFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $vehicleUsersService = new VehicleUsers();
        $vehicleUsersService->setLogger($container->get("logger_default"));
        return $vehicleUsersService;
    }
}
