<?php
namespace User\V1\Rpc\ActivateRoom;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\Hal\View\HalJsonModel;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use Zend\Json\Json;
use User\Mapper\RoomUsers as RoomUsersMapper;

class ActivateRoomController extends AbstractActionController
{
    protected $activateRoomValidator;
    protected $activateRoomService;

    public function __construct(
        \User\Mapper\RoomUsers $roomUsersMapper, 
        $activateRoomService,$activateRoomValidator)
    {
        $this->setRoomUsersMapper($roomUsersMapper);
        $this->activateRoomValidator = $activateRoomValidator;
        $this->activateRoomService = $activateRoomService;
    }

    public function activateRoomAction()
    {
        $this->activateRoomValidator->setData(Json::decode($this->getRequest()->getContent(), true));
        $input = $this->activateRoomValidator->getValues();
        // var_dump($input['uuid']);exit();   

        $roomUser = $this->getRoomUsersMapper()->fetchOneBy(['uuid' => $input['uuid']]);
        // $result = $roomUsersCollection->getResult();
        // var_dump($roomUsersCollection);exit();   
        // $data['isActive'] = '1';
        // $data['uuid'] = "ce4c5a95-cff3-11eb-8c8d-0242ac110002";
        // var_dump($data);
        // var_dump($this->activateRoomValidator->getValues());exit();   

        try{
            $this->activateRoomService->update($roomUser,$this->activateRoomValidator->getValues());
            return new HalJsonModel($this->activateRoomService->getActivateRoomEvent()->getActivateRoomData());
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
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
