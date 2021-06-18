<?php
namespace User\V1\Rpc\UserVehicleStats;

class UserVehicleStatsControllerFactory
{
    public function __invoke($controllers)
    {
        $userProfile = $controllers->get(\User\Mapper\UserProfile::class);
        $vehicle = $controllers->get(\User\Mapper\Vehicle::class);
        $vehicleUsersMapper = $controllers->get(\User\Mapper\VehicleUsers::class);
        $controller = new UserVehicleStatsController(
            $userProfile,
            $vehicle,
            $vehicleUsersMapper
        );
        return $controller;
    }
}
