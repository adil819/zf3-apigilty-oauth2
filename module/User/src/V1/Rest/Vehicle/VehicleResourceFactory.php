<?php
namespace User\V1\Rest\Vehicle;

class VehicleResourceFactory
{
    public function __invoke($services)
    {
        $vehicleMapper = $services->get(\User\Mapper\Vehicle::class);
        $vehicleService = $services->get(\User\V1\Service\Vehicle::class);
        $resource = new VehicleResource($vehicleMapper);
        $resource->setVehicleService($vehicleService);
        return $resource;
    }
}
