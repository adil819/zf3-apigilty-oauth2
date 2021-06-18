<?php
namespace User\V1\Rpc\UserVehicleStats;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\Hal\View\HalJsonModel;
use User\Mapper\Vehicle as VehicleMapper;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\VehicleUsers as VehicleUsersMapper;

class UserVehicleStatsController extends AbstractActionController
{
    public function __construct(
        \User\Mapper\UserProfile $userProfile,
        \User\Mapper\Vehicle $vehicle,
        \User\Mapper\VehicleUsers $vehicleUsersMapper)
    {
        $this->setUserProfileMapper($userProfile);
        $this->setVehicleMapper($vehicle);
        $this->setVehicleUsersMapper($vehicleUsersMapper);
    }

    public function userVehicleStatsAction()
    {
        $queryParams = [];

        $userProfileCollection = $this->getUserProfileMapper()->fetchAll($queryParams);
        $result = $userProfileCollection->getResult();
        $totalUser = count($result);

        $queryParamsV = [
            "brand" => "Suzuki"
        ];
        $vehicleCollection = $this->getVehicleMapper()->fetchAll($queryParamsV);
        $result = $vehicleCollection->getResult();
        $totalVehicle = count($result);

        $vehicleUsersCollection = $this->getVehicleUsersMapper()->fetchAll($queryParams);
        $result = $vehicleUsersCollection->getResult();
        $totalVehicleUsers = count($result);

        $response = [
            "totalUserProfile" => $totalUser,
            "totalVehicle" => $totalVehicle,
            "totalVehicleUsers" => $totalVehicleUsers
        ];

        return new HalJsonModel($response);
    }

    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    public function setUserProfileMapper($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;

        return $this;
    }

    public function getVehicleMapper()
    {
        return $this->vehicleMapper;
    }

    public function setVehicleMapper($vehicleMapper)
    {
        $this->vehicleMapper = $vehicleMapper;
        
        return $this;
    }

    public function getVehicleUsersMapper()
    {
        return $this->vehicleUsersMapper;
    }

    public function setVehicleUsersMapper($vehicleUsersMapper)
    {
        $this->vehicleUsersMapper = $vehicleUsersMapper;

        return $this;
    }
}
