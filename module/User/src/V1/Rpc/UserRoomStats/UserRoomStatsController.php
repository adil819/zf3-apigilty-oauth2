<?php
namespace User\V1\Rpc\UserRoomStats;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\Hal\View\HalJsonModel;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use User\Mapper\Room as RoomMapper;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\RoomUsers as RoomUsersMapper;

class UserRoomStatsController extends AbstractActionController
{
    public function __construct(
        \User\Mapper\UserProfile $userProfile,
        \User\Mapper\Room $room,
        \User\Mapper\RoomUsers $roomUsersMapper)
    {
        $this->setUserProfileMapper($userProfile);
        $this->setRoomMapper($room);
        $this->setRoomUsersMapper($roomUsersMapper);
    }


    public function userRoomStatsAction()
    {
        // $userProfile = [];
        // if (! is_null($this->userProfile)){
        //     return new HalJsonModel(['uuid' => $this->userProfile->getUuid()]);
        // } else {
        //     return new ApiProblemResponse(new ApiProblem(404, "User Identity not found"));
        // }

        // $userProfile = $this->userProfile;

        // if(is_null($userProfile)){
        //     return new ApiProblemResponse(new ApiProblem(404, "User Not Found"));
        // }
        $queryParams = [];
        // $queryParams = [
        //     'userProfileUuid' => $userProfile->getUuid()
        // ];
        
        $userProfileCollection = $this->getUserProfileMapper()->fetchAll($queryParams);
        $result = $userProfileCollection->getResult();
        $totalUser = count($result);
 
        $queryParamsR = [
            // "uuid" => "f47a88ed-ccbf-11eb-b51a-0242ac110002"
            "capacity" => "10"
        ];               
        $roomCollection = $this->getRoomMapper()->fetchAll($queryParamsR);
        $result = $roomCollection->getResult();
        $totalRoom = count($result);

        $queryParamsRU = [
            // "room_uuid" => "f47a88ed-ccbf-11eb-b51a-0242ac110002"
        ];        
        $roomUsersCollection = $this->getRoomUsersMapper()->fetchAll($queryParamsRU);
        $result = $roomUsersCollection->getResult();
        $totalRoomUsers = count($result);
    
        $response = [
            "totalUserProfile" => $totalUser,
            "totalRoom" => $totalRoom,
            "totalRoomUsers" => $totalRoomUsers
        ];

        return new HalJsonModel($response); 
    }

    /**
     * Get the value of roomUsersMapper
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * Set the value of roomUsersMapper
     *
     * @return  self
     */
    public function setUserProfileMapper($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;

        return $this;
    }

    /**
     * Get the value of roomUsersMapper
     */
    public function getRoomMapper()
    {
        return $this->roomMapper;
    }

    /**
     * Set the value of roomUsersMapper
     *
     * @return  self
     */
    public function setRoomMapper($roomMapper)
    {
        $this->roomMapper = $roomMapper;

        return $this;
    }

    /**
     * Get the value of roomUsersMapper
     */
    public function getRoomUsersMapper()
    {
        return $this->roomUsersMapper;
    }

    /**
     * Set the value of roomUsersMapper
     *
     * @return  self
     */
    public function setRoomUsersMapper($roomUsersMapper)
    {
        $this->roomUsersMapper = $roomUsersMapper;

        return $this;
    }
}
