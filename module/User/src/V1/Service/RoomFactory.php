<?php
namespace User\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RoomFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $roomMapper = $container->get('User\Mapper\Room');
        return new Room($roomMapper);
    }
}
