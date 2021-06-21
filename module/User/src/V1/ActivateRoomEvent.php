<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\ORM\Entity\EntityInterface;

class ActivateRoomEvent extends Event
{
    /**#@+
     * ActivateRoom events triggered by eventmanager
     */
    const EVENT_UPDATE_ROOMUSERS = 'update.roomusers';
    const EVENT_UPDATE_ROOMUSERS_SUCCESS = 'update.roomusers.success';
    const EVENT_UPDATE_ROOMUSERS_ERROR   = 'update.roomusers.error';
    /**#@-*/

    /**
     * @var Aqilix\ORM\Entity\EntityInterface
     */
    protected $userEntity;

    /**
     * @var array
     */
    protected $activateRoomData;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @var User\Entity\UserRoomUsers
     */
    protected $roomUsersEntity;

    /**
     * @var array
     */
    protected $updateData;    

    /**
     * @return the $user
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     * @param Aqilix\ORM\Entity\EntityInterface $user
     */
    public function setUserEntity(EntityInterface $user)
    {
        $this->userEntity = $user;
    }

    /**
     * @return the $activateroomData
     */
    public function getActivateRoomData()
    {
        return $this->activateRoomData;
    }

    /**
     * @param Array $activateroomData
     */
    public function setActivateRoomData(array $activateRoomData)
    {
        $this->activateRoomData = $activateRoomData;
    }

    /**
     * @return the $exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return the $updateData
     */
    public function getUpdateData()
    {
        return $this->updateData;
    }

    /**
     * @param object $updateData
     */
    public function setUpdateData($updateData)
    {
        $this->updateData = $updateData;
    }

    /**
     * Get the value of roomUsersEntity
     */
    public function getRoomUsersEntity()
    {
        return $this->roomUsersEntity;
    }

    /**
     * Set the value of roomusersEntity
     */
    public function setRoomUsersEntity($roomUsersEntity): self
    {
        $this->roomUsersEntity = $roomUsersEntity;

        return $this;
    }
}
