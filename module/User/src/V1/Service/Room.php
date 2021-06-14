<?php
namespace User\V1\Service;

use PDO;
use Psr\Log\LoggerAwareTrait;
use User\V1\RoomEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\Mapper\Room as RoomMapper;
use User\Entity\Room as RoomEntity;

class Room
{
    use LoggerAwareTrait;
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\RoomEvent;
     */

    protected $roomEvent;


    // public function __construct(RoomMapper $roomMapper)
    // {
    //     $this->setRoomMapper($roomMapper);
    // }

    public function __construct()
    {
    }

    /**
     * @return \User\V1\RoomEvent
     */
    public function getRoomEvent()
    {
        if ($this->roomEvent == null) {
            $this->roomEvent = new RoomEvent();
        }

        return $this->roomEvent;
    }

    /**
     * @param RoomEvent $roomEvent
     */
    public function setRoomEvent(RoomEvent $roomEvent)
    {
        $this->roomEvent = $roomEvent;
    }

    /**
     * Update User Room
     *
     * @param \User\Entity\Room  $room
     * @param array                     $updateData
     */
    // public function update($room, $inputFilter) //DITIRU DARI PROFILE
    // {
    //     $roomEvent = $this->getRoomEvent();
    //     $roomEvent->setRoomEntity($room);
    //     $roomEvent->setUpdateData($inputFilter->getValues());
    //     $roomEvent->setInputFilter($inputFilter);
    //     $roomEvent->setName(RoomEvent::EVENT_UPDATE_ROOM);
    //     $update = $this->getEventManager()->triggerEvent($roomEvent);
    //     if ($update->stopped()) {
    //         $roomEvent->setName(RoomEvent::EVENT_UPDATE_ROOM_ERROR);
    //         $roomEvent->setException($update->last());
    //         $this->getEventManager()->triggerEvent($roomEvent);
    //         throw $roomEvent->getException();
    //     } else {
    //         $roomEvent->setName(RoomEvent::EVENT_UPDATE_ROOM_SUCCESS);
    //         $this->getEventManager()->triggerEvent($roomEvent);
    //     }
    // }

    public function register(array $roomData)  //DITIRU DARI SIGNUP
    {
        $this->getRoomEvent()->setRoomData($roomData);
        $roomEvent = $this->getRoomEvent();
        $roomEvent->setName(RoomEvent::EVENT_INSERT_ROOM);
        $insert = $this->getEventManager()->triggerEvent($roomEvent);
        if ($insert->stopped()) {
            $roomEvent->setException($insert->last());
            $roomEvent->setName(RoomEvent::EVENT_INSERT_ROOM_ERROR);
            $insert = $this->getEventManager()->triggerEvent($roomEvent);
            throw $this->getRoomEvent()->getException();
        } else {
            $roomEvent->setName(RoomEvent::EVENT_INSERT_ROOM_SUCCESS);
            $this->getEventManager()->triggerEvent($roomEvent);
        }
    }

    public function save(ZendInputFilter $inputFilter) {   // DITIRU DARI DEVICE
        $roomEvent = new RoomEvent();
        $roomEvent->setInputFilter($inputFilter);
        $roomEvent->setName(RoomEvent::EVENT_CREATE_ROOM);
        $create = $this->getEventManager()->triggerEvent($roomEvent);
        if ($create->stopped()){
            $roomEvent->setName(RoomEvent::EVENT_CREATE_ROOM_ERROR);
            $roomEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($roomEvent);
            throw $roomEvent->getException();
        } else {
            $roomEvent->setName(RoomEvent::EVENT_CREATE_ROOM_SUCCESS);
            $this->getEventManager()->triggerEvent($roomEvent);
            return $roomEvent->getRoomEntity();
        }
    }
    
    public function update(RoomEntity $room, ZendInputFilter $newData){
        $roomEvent = new RoomEvent();
        $roomEvent->setInputFilter($newData);
        $roomEvent->setUpdateData($newData->getValues());
        $roomEvent->setRoomEntity($room);
        $roomEvent->setName(RoomEvent::EVENT_UPDATE_ROOM);
        $create = $this->getEventManager()->triggerEvent($roomEvent); 
        if ($create->stopped()){
            $roomEvent->setName(RoomEvent::EVENT_UPDATE_ROOM_ERROR);
            $roomEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($roomEvent);
            throw $roomEvent->getException();
        } else {
            $roomEvent->setName(RoomEvent::EVENT_UPDATE_ROOM_SUCCESS);
            $this->getEventManager()->triggerEvent($roomEvent);
            return $roomEvent->getRoomEntity();
        }
    }

    public function delete(RoomEntity $room){
        $roomEvent = new RoomEvent();
        $roomEvent->setRoomEntity($room);
        $roomEvent->setName(RoomEvent::EVENT_DELETE_ROOM);
        $delete = $this->getEventManager()->triggerEvent($roomEvent);
        if ($delete->stopped()){
            $roomEvent->setName(RoomEvent::EVENT_DELETE_ROOM_ERROR);
            $roomEvent->setException($delete->last());
            $this->getEventManager()->triggerEvent($roomEvent);
            throw $roomEvent->getException();
        } else {
            $roomEvent->setName(RoomEvent::EVENT_DELETE_ROOM_SUCCESS);
            $this->getEventManager()->triggerEvent($roomEvent);
            // return $roomEvent->getRoomEntity();
            return true;  // => DISINI BEDANYA KALAU DELETE
        }
    }
}
