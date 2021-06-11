<?php
namespace User\V1\Service;

use User\V1\RoomEvent;
use Zend\EventManager\EventManagerAwareTrait;
use User\Mapper\Room as RoomMapper;

class Room
{
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\RoomEvent
     */
    protected $roomEvent;

    /**
     * @var \User\Mapper\Room
     */
    protected $roomMapper;

    public function __construct(RoomMapper $roomMapper)
    {
        $this->setRoomMapper($roomMapper);
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
     * @param RoomEvent $signupEvent
     */
    public function setRoomEvent(RoomEvent $roomEvent)
    {
        $this->roomEvent = $roomEvent;
    }

    /**
     * @return the $roomMapper
     */
    public function getRoomMapper()
    {
        return $this->roomMapper;
    }

    /**
     * @param RoomMapper $roomMapper
     */
    public function setRoomMapper(RoomMapper $roomMapper)
    {
        $this->roomMapper = $roomMapper;
    }

    /**
     * Update User Room
     *
     * @param \User\Entity\Room  $room
     * @param array                     $updateData
     */
    public function update($room, $inputFilter)
    {
        $roomEvent = $this->getRoomEvent();
        $roomEvent->setRoomEntity($room);
        $roomEvent->setUpdateData($inputFilter->getValues());
        $roomEvent->setInputFilter($inputFilter);
        $roomEvent->setName(RoomEvent::EVENT_UPDATE_ROOM);
        $update = $this->getEventManager()->triggerEvent($roomEvent);
        if ($update->stopped()) {
            $roomEvent->setName(RoomEvent::EVENT_UPDATE_ROOM_ERROR);
            $roomEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($roomEvent);
            throw $roomEvent->getException();
        } else {
            $roomEvent->setName(RoomEvent::EVENT_UPDATE_ROOM_SUCCESS);
            $this->getEventManager()->triggerEvent($roomEvent);
        }
    }
}
