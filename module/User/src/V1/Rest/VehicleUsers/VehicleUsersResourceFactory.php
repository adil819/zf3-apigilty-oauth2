<?php
namespace User\V1\Rest\VehicleUsers;

class VehicleUsersResourceFactory
{
    public function __invoke($services)
    {
        $vehicleUsersMapper = $services->get(\User\Mapper\VehicleUsers::class);
        $vehicleUsersService = $services->get(\User\V1\Service\VehicleUsers::class);
        $resource = new VehicleUsersResource($vehicleUsersMapper);
        $resource->setVehicleUsersService($vehicleUsersService);
        return $resource;
    }
}
