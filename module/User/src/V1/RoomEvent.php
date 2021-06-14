<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\ORM\Entity\EntityInterface;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class RoomEvent extends Event
{
    /**#@+
     * Room events triggered by eventmanager
     */
    # UPDATE DITIRU DARI PROFILE
    const EVENT_UPDATE_ROOM  = 'update.room';
    const EVENT_UPDATE_ROOM_ERROR   = 'update.room.error';
    const EVENT_UPDATE_ROOM_SUCCESS = 'update.room.success';

    #INSERT DITIRU DARI SIGNUP
    const EVENT_INSERT_ROOM  = 'insert.room';
    const EVENT_INSERT_ROOM_ERROR   = 'insert.room.error';
    const EVENT_INSERT_ROOM_SUCCESS = 'insert.room.success';

    #CREATE DITIRU DARI DEVICE
    const EVENT_CREATE_ROOM  = 'create.room';
    const EVENT_CREATE_ROOM_ERROR   = 'create.room.error';
    const EVENT_CREATE_ROOM_SUCCESS = 'create.room.success';
    /**#@-*/

    /**
     * @var User\Entity\UserRoom
     */
    protected $roomEntity;

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
     * @param Array $roomData
     */
    public function setRoomData(array $roomData)
    {
        $this->roomData = $roomData;
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
     * Get the value of roomEntity
     */
    public function getRoomEntity()
    {
        return $this->roomEntity;
    }

    /**
     * Set the value of roomEntity
     */
    public function setRoomEntity($roomEntity): self
    {
        $this->roomEntity = $roomEntity;

        return $this;
    }
}
