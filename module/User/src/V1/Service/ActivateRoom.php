<?php
namespace User\V1\Service;

use User\V1\ActivateRoomEvent;
use Zend\EventManager\EventManagerAwareTrait;
use User\Entity\RoomUsers as RoomUsersEntity;

class ActivateRoom
{
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\ActivateRoomEvent
     */
    protected $activateRoomEvent;

    public function __construct()
    {
    }

    /**
     * @return $signupEvent
     */
    public function getActivateRoomEvent()
    {
        if ($this->activateRoomEvent == null) {
            $this->activateRoomEvent = new ActivateRoomEvent();
        }

        return $this->activateRoomEvent;
    }

    /**
     * @param ActivateRoomEvent $ActivateRoomEvent
     */
    public function setActivateRoomEvent(ActivateRoomEvent $activateRoomEvent)
    {
        $this->activateRoomEvent = $activateRoomEvent;
    }

    /**
     * Register new user
     *
     * @param  array $activateRoomEventData
     * @throw  \RuntimeException
     * @return void
     */
    public function update(RoomUsersEntity $roomUsers, array $activateRoomData)
    {
        $this->getActivateRoomEvent()->setActivateRoomData($activateRoomData);
        $activateRoomEvent = $this->getActivateRoomEvent();
        // var_dump($activateRoomData);exit();
        $activateRoomEvent->setUpdateData($activateRoomData);
        $activateRoomEvent->setRoomUsersEntity($roomUsers);
        $activateRoomEvent->setName(ActivateRoomEvent::EVENT_UPDATE_ROOMUSERS);
        $update = $this->getEventManager()->triggerEvent($activateRoomEvent);
        if ($update->stopped()) {
            $activateRoomEvent->setException($update->last());
            $activateRoomEvent->setName(ActivateRoomEvent::EVENT_UPDATE_ROOMUSERS_ERROR);
            $update = $this->getEventManager()->triggerEvent($activateRoomEvent);
            throw $this->getActivateRoomEvent()->getException();
        } else {
            $activateRoomEvent->setName(ActivateRoomEvent::EVENT_UPDATE_ROOMUSERS_SUCCESS);
            $this->getEventManager()->triggerEvent($activateRoomEvent);
        }
    }
}
