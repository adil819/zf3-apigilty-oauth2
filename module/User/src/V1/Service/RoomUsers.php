<?php
namespace User\V1\Service;

use Psr\Log\LoggerAwareTrait;
use User\V1\RoomUsersEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\Mapper\RoomUsers as RoomUsersMapper;
use User\Entity\RoomUsers as RoomUsersEntity;

class RoomUsers
{
    use LoggerAwareTrait;
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\RoomUsersEvent;
     */

    protected $roomUsersEvent;


    // public function __construct(RoomUsersMapper $roomUsersMapper)
    // {
    //     $this->setRoomUsersMapper($roomUsersMapper);
    // }

    public function __construct()
    {
    }

    /**
     * @return \User\V1\RoomUsersEvent
     */
    public function getRoomUsersEvent()
    {
        if ($this->roomUsersEvent == null) {
            $this->roomUsersEvent = new RoomUsersEvent();
        }

        return $this->roomUsersEvent;
    }

    /**
     * @param RoomUsersEvent $roomUsersEvent
     */
    public function setRoomUsersEvent(RoomUsersEvent $roomUsersEvent)
    {
        $this->roomUsersEvent = $roomUsersEvent;
    }

    /**
     * Update User RoomUsers
     *
     * @param \User\Entity\RoomUsers  $roomUsers
     * @param array                     $updateData
     */
    // public function update($roomusers, $inputFilter) //DITIRU DARI PROFILE
    // {
    //     $roomUsersEvent = $this->getRoomUsersEvent();
    //     $roomUsersEvent->setRoomUsersEntity($roomusers);
    //     $roomUsersEvent->setUpdateData($inputFilter->getValues());
    //     $roomUsersEvent->setInputFilter($inputFilter);
    //     $roomUsersEvent->setName(RoomUsersEvent::EVENT_UPDATE_ROOM_USERS);
    //     $update = $this->getEventManager()->triggerEvent($roomUsersEvent);
    //     if ($update->stopped()) {
    //         $roomUsersEvent->setName(RoomUsersEvent::EVENT_UPDATE_ROOM_USERS_ERROR);
    //         $roomUsersEvent->setException($update->last());
    //         $this->getEventManager()->triggerEvent($roomUsersEvent);
    //         throw $roomUsersEvent->getException();
    //     } else {
    //         $roomUsersEvent->setName(RoomUsersEvent::EVENT_UPDATE_ROOM_USERS_SUCCESS);
    //         $this->getEventManager()->triggerEvent($roomUsersEvent);
    //     }
    // }

    public function save(ZendInputFilter $inputFilter)
    {
   // DITIRU DARI DEVICE
        $roomUsersEvent = new RoomUsersEvent();
        $roomUsersEvent->setInputFilter($inputFilter);
        $roomUsersEvent->setName(RoomUsersEvent::EVENT_CREATE_ROOMUSERS);
        $create = $this->getEventManager()->triggerEvent($roomUsersEvent);
        if ($create->stopped()) {
            $roomUsersEvent->setName(RoomUsersEvent::EVENT_CREATE_ROOMUSERS_ERROR);
            $roomUsersEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($roomUsersEvent);
            throw $roomUsersEvent->getException();
        } else {
            $roomUsersEvent->setName(RoomUsersEvent::EVENT_CREATE_ROOMUSERS_SUCCESS);
            $this->getEventManager()->triggerEvent($roomUsersEvent);
            return $roomUsersEvent->getRoomUsersEntity();
        }
    }

    public function update(RoomUsersEntity $roomUsers, ZendInputFilter $newData)
    {
        $roomUsersEvent = new RoomUsersEvent();
        $roomUsersEvent->setInputFilter($newData);
        $roomUsersEvent->setUpdateData($newData->getValues());
        $roomUsersEvent->setRoomUsersEntity($roomUsers);
        $roomUsersEvent->setName(RoomUsersEvent::EVENT_UPDATE_ROOMUSERS);
        $update = $this->getEventManager()->triggerEvent($roomUsersEvent);
        if ($update->stopped()) {
            $roomUsersEvent->setName(RoomUsersEvent::EVENT_UPDATE_ROOMUSERS_ERROR);
            $roomUsersEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($roomUsersEvent);
            throw $roomUsersEvent->getException();
        } else {
            // var_dump($roomUsersEvent);
            $roomUsersEvent->setName(RoomUsersEvent::EVENT_UPDATE_ROOMUSERS_SUCCESS);
            $this->getEventManager()->triggerEvent($roomUsersEvent);
            return $roomUsersEvent->getRoomUsersEntity();
        }
    }

    public function delete(RoomUsersEntity $roomUsers)
    {
        $roomUsersEvent = new RoomUsersEvent();
        $roomUsersEvent->setRoomUsersEntity($roomUsers);
        $roomUsersEvent->setName(RoomUsersEvent::EVENT_DELETE_ROOMUSERS);
        $delete = $this->getEventManager()->triggerEvent($roomUsersEvent);
        if ($delete->stopped()) {
            $roomUsersEvent->setName(RoomUsersEvent::EVENT_DELETE_ROOMUSERS_ERROR);
            $roomUsersEvent->setException($delete->last());
            $this->getEventManager()->triggerEvent($roomUsersEvent);
            throw $roomUsersEvent->getException();
        } else {
            $roomUsersEvent->setName(RoomUsersEvent::EVENT_DELETE_ROOMUSERS_SUCCESS);
            $this->getEventManager()->triggerEvent($roomUsersEvent);
            // return $roomUsersEvent->getRoomUsersEntity();
            return true;  // => DISINI BEDANYA KALAU DELETE
        }
    }
}
