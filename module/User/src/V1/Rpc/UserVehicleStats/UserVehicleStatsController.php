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
        $user,
        \User\Mapper\UserProfile $userProfile,
        \User\Mapper\Vehicle $vehicle,
        \User\Mapper\VehicleUsers $vehicleUsersMapper)
    {
        $this->user = $user;
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
            // "brand" => "Suzuki"
        ];
        $vehicleCollection = $this->getVehicleMapper()->fetchAll($queryParamsV);
        $result1 = $vehicleCollection->getResult();
        $totalVehicle = count($result1);

        $vehicleUsersCollection = $this->getVehicleUsersMapper()->fetchAll($queryParams);
        $result = $vehicleUsersCollection->getResult();
        $totalVehiclesUsers = count($result);

        $totalYourVehicles = 0;
        $listYourVehicles = [];
        foreach($result as $vehicleUser){
            if($vehicleUser->getUserProfile()->getUuid() == $this->user->getUuid()){
                $totalYourVehicles += 1;
                array_push($listYourVehicles, $vehicleUser->getVehicle()->getBrand());
            }
        }

        foreach($result1 as $vehicle){
            $totalVehicleUsers[$vehicle->getBrand()] = 0;
            $listVehicleUsers[$vehicle->getBrand()] = [];
            foreach($result as $vehicleUser){
                if($vehicle->getUuid() == $vehicleUser->getVehicle()->getUuid()){
                    $totalVehicleUsers[$vehicle->getBrand()] += 1;
                    $name = $vehicleUser->getUserProfile()->getFirstName . " " . $vehicleUser->getUserProfile()->getLastname();
                    array_push($listVehicleUsers[$vehicle->getBrand()], $name);
                }
            }
        }

        $response = [
            "currentUser" => [
                "name"  => $this->user->getFirstName() . " " . $this->user->getLastName(),
                "totalYourVehicles" => $totalYourVehicles,
                "listYourVehicles" => $listYourVehicles
            ],
            "totalUser" => $totalUser,
            "totalVehicle" => $totalVehicle,
            "totalVehicleUsed" => $totalVehiclesUsers,
            "totalVehicleBooked" => $totalVehicleUsers,
            "listVehicleBooked" => $listVehicleUsers
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
