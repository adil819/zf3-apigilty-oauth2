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
    private $user;

    public function __construct(
        $user,
        \User\Mapper\UserProfile $userProfile,
        \User\Mapper\Room $room,
        \User\Mapper\RoomUsers $roomUsersMapper)
    {
        $this->user = $user;
        $this->setUserProfileMapper($userProfile);
        $this->setRoomMapper($room);
        $this->setRoomUsersMapper($roomUsersMapper);
    }


    public function userRoomStatsAction()
    {
        $user = [];
    if (! is_null($this->user)){
            // return new HalJsonModel(['uuid' => $this->user->getUuid()]);
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
            // "capacity" => "10"
        ];               
        $roomCollection = $this->getRoomMapper()->fetchAll($queryParamsR);
        $result1 = $roomCollection->getResult();
        $totalRoom = count($result1);

        foreach($result1 as $room){
            
        }

        $queryParamsRU = [
            // "userProfileUuid" => $this->user->getUuid()
            // "uuid" => "1749265f-ce46-11eb-8c8d-0242ac110002"
            // BETULIN DULU DI FETCH ALAM DI ROOMUSERS RESOURCE ATAU MAPPER
        ];        
        $roomUsersCollection = $this->getRoomUsersMapper()->fetchAll($queryParamsRU);
        $result2 = $roomUsersCollection->getResult();
        $totalRoomUsers = count($result2);

        $reservation = 0;
        $listYourReservation = [];
        // $totalPerRoom[0] = 0;
        foreach($result2 as $roomUser){
            if ($roomUser->getUserProfile()->getUuid() == $this->user->getUuid()){
                $reservation += 1;
                array_push($listYourReservation, $roomUser->getRoom()->getName());
            } 
        }

        foreach($result1 as $room){
            $perRoom[$room->getName()] = 0;
            $perRoom2[$room->getName()] = [];
            foreach($result2 as $roomUser) {
                if($room->getUuid() == $roomUser->getRoom()->getUuid()){
                    $perRoom[$room->getName()] += 1;
                    $name = $roomUser->getUserProfile()->getFirstName() . " " . $roomUser->getUserProfile()->getLastName();
                    array_push($perRoom2[$room->getName()], $name);
                }
            }
        }

        // foreach($result1 as $room){
        //     $perRoom[$room->getName()] = 0;
        //     foreach($result2 as $roomUser) {
        //         if($room->getUuid() == $roomUser->getRoom()->getUuid()){
        //             $perRoom[$room->getName()] += 1;
        //         }
        //     }
        // }

        // foreach($result1 as $room){
        //     $perRoom2[$room->getName()] = [];
        //     foreach($result2 as $roomUser) {
        //         if($room->getUuid() == $roomUser->getRoom()->getUuid()){
        //             // $perRoom[$room->getName()] += 1;
        //             $name = $roomUser->getUserProfile()->getFirstName() . " " . $roomUser->getUserProfile()->getLastName();
        //             array_push($perRoom2[$room->getName()], $name);
        //         }
        //     }
        // }
    
        $response = [
            "currentUser" => [
                "name"  => $this->user->getFirstName() . " " . $this->user->getLastName(),
                "totalYourReservation" => $reservation,
                "listYourReservation" => $listYourReservation
            ],
            "totalUser" => $totalUser,
            "totalRoom" => $totalRoom,
            "totalReservation" => $totalRoomUsers,
            "totalReservationPerRoom" => $perRoom,            
            "userPerRoom" => $perRoom2
        ];

        return new HalJsonModel($response); 

    } else {
        return new ApiProblemResponse(new ApiProblem(404, "User Identity not found"));
    }

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
