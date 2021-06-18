<?php
namespace User\V1\Rpc\UserVehicleStats;

class UserVehicleStatsControllerFactory
{
    public function __invoke($controllers)
    {
        $authentication = $controllers->get('authentication');
        $email = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $user = $controllers->get('User\Mapper\UserProfile')->fetchOneBy(['user' => $email]);

        $userProfile = $controllers->get(\User\Mapper\UserProfile::class);
        $vehicle = $controllers->get(\User\Mapper\Vehicle::class);
        $vehicleUsersMapper = $controllers->get(\User\Mapper\VehicleUsers::class);
        $controller = new UserVehicleStatsController(
            $user,
            $userProfile,
            $vehicle,
            $vehicleUsersMapper
        );
        return $controller;
    }
}
