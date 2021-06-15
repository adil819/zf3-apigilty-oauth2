<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\ORM\Entity\EntityInterface;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class VehicleEvent extends Event
{
    /**#@+
     * Vehicle events triggered by eventmanager
     */
    # UPDATE DITIRU DARI PROFILE
    const EVENT_UPDATE_VEHICLE  = 'update.vehicle';
    const EVENT_UPDATE_VEHICLE_ERROR   = 'update.vehicle.error';
    const EVENT_UPDATE_VEHICLE_SUCCESS = 'update.vehicle.success';

    #INSERT DITIRU DARI SIGNUP
    const EVENT_INSERT_VEHICLE  = 'insert.vehicle';
    const EVENT_INSERT_VEHICLE_ERROR   = 'insert.vehicle.error';
    const EVENT_INSERT_VEHICLE_SUCCESS = 'insert.vehicle.success';

    #CREATE DITIRU DARI DEVICE
    const EVENT_CREATE_VEHICLE  = 'create.vehicle';
    const EVENT_CREATE_VEHICLE_ERROR   = 'create.vehicle.error';
    const EVENT_CREATE_VEHICLE_SUCCESS = 'create.vehicle.success';

    #DELETE BUAT SENDIRI TANPA CONTEK DENGAN MENGINGAT ALUR NYA
    const EVENT_DELETE_VEHICLE = 'delete.vehicle';
    const EVENT_DELETE_VEHICLE_ERROR = 'delete.vehicle.error';
    const EVENT_DELETE_VEHICLE_SUCCESS = 'delete.vehicle.success';

    /**#@-*/

    /**
     * @var User\Entity\UserVehicle
     */
    protected $vehicleEntity;

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
     * @param Array $vehicleData
     */
    public function setVehicleData(array $vehicleData)
    {
        $this->vehicleData = $vehicleData;
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
     * Get the value of vehicleEntity
     */
    public function getVehicleEntity()
    {
        return $this->vehicleEntity;
    }

    /**
     * Set the value of vehicleEntity
     */
    public function setVehicleEntity($vehicleEntity): self
    {
        $this->vehicleEntity = $vehicleEntity;

        return $this;
    }
}
