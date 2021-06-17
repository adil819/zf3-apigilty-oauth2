<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\ORM\Entity\EntityInterface;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class VehicleUsersEvent extends Event
{
    /**#@+
     * VehicleUsers events triggered by eventmanager
     */
    # UPDATE DITIRU DARI PROFILE
    const EVENT_UPDATE_VEHICLEUSERS  = 'update.vehicleusers';
    const EVENT_UPDATE_VEHICLEUSERS_ERROR   = 'update.vehicleusers.error';
    const EVENT_UPDATE_VEHICLEUSERS_SUCCESS = 'update.vehicleusers.success';

    // #INSERT DITIRU DARI SIGNUP
    // const EVENT_INSERT_VEHICLE_USERS  = 'insert.vehicle.users';
    // const EVENT_INSERT_VEHICLE_USERS_ERROR   = 'insert.vehicle.users.error';
    // const EVENT_INSERT_VEHICLE_USERS_SUCCESS = 'insert.vehicle.users.success';

    #CREATE DITIRU DARI DEVICE
    const EVENT_CREATE_VEHICLEUSERS  = 'create.vehicleusers';
    const EVENT_CREATE_VEHICLEUSERS_ERROR   = 'create.vehicleusers.error';
    const EVENT_CREATE_VEHICLEUSERS_SUCCESS = 'create.vehicleusers.success';

    #DELETE BUAT SENDIRI TANPA CONTEK DENGAN MENGINGAT ALUR NYA
    const EVENT_DELETE_VEHICLEUSERS = 'delete.vehicleusers';
    const EVENT_DELETE_VEHICLEUSERS_ERROR = 'delete.vehicleusers.error';
    const EVENT_DELETE_VEHICLEUSERS_SUCCESS = 'delete.vehicleusers.success';

    /**#@-*/

    /**
     * @var User\Entity\UserVehicleUsers
     */
    protected $vehicleUsersEntity;

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
     * @param Array $vehicleusersData
     */
    public function setVehicleUsersData(array $vehicleUsersData)
    {
        $this->vehicleUsersData = $vehicleUsersData;
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
     * Get the value of vehicleUsersEntity
     */
    public function getVehicleUsersEntity()
    {
        return $this->vehicleUsersEntity;
    }

    /**
     * Set the value of vehicleusersEntity
     */
    public function setVehicleUsersEntity($vehicleUsersEntity): self
    {
        $this->vehicleUsersEntity = $vehicleUsersEntity;

        return $this;
    }
}
