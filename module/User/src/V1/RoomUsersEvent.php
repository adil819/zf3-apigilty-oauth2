<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\ORM\Entity\EntityInterface;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class RoomUsersEvent extends Event
{
    /**#@+
     * RoomUsers events triggered by eventmanager
     */
    // # UPDATE DITIRU DARI PROFILE
    // const EVENT_UPDATE_ROOM_USERS  = 'update.room.users';
    // const EVENT_UPDATE_ROOM_USERS_ERROR   = 'update.room.users.error';
    // const EVENT_UPDATE_ROOM_USERS_SUCCESS = 'update.room.users.success';

    // #INSERT DITIRU DARI SIGNUP
    // const EVENT_INSERT_ROOM_USERS  = 'insert.room.users';
    // const EVENT_INSERT_ROOM_USERS_ERROR   = 'insert.room.users.error';
    // const EVENT_INSERT_ROOM_USERS_SUCCESS = 'insert.room.users.success';

    #CREATE DITIRU DARI DEVICE
    const EVENT_CREATE_ROOMUSERS  = 'create.roomusers';
    const EVENT_CREATE_ROOMUSERS_ERROR   = 'create.roomusers.error';
    const EVENT_CREATE_ROOMUSERS_SUCCESS = 'create.roomusers.success';

    // #DELETE BUAT SENDIRI TANPA CONTEK DENGAN MENGINGAT ALUR NYA
    // const EVENT_DELETE_ROOM_USERS = 'delete.room.users';
    // const EVENT_DELETE_ROOM_USERS_ERROR = 'delete.room.users.error';
    // const EVENT_DELETE_ROOM_USERS_SUCCESS = 'delete.room.users.success';

    /**#@-*/

    /**
     * @var User\Entity\UserRoomUsers
     */
    protected $roomUsersEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var array
     */
    protected $updateData;

    /**
     * @var \Exception
     */
    protected $exception;

    // INI DIMODIFIKASI DARI SignupEvent
    /**
     * @param Array $roomusersData
     */
    public function setRoomUsersData(array $roomUsersData)
    {
        $this->roomUsersData = $roomUsersData;
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
     * @return the $inputFilter
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * @param Zend\InputFilter\InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
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
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
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
