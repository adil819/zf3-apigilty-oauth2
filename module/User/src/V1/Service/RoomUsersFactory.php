<?php
namespace User\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RoomUsersFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $roomUsersService = new RoomUsers();
        $roomUsersService->setLogger($container->get("logger_default"));
        return $roomUsersService;
    }
}
