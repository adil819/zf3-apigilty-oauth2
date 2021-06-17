<?php
namespace User\V1\Service;

use Psr\Log\LoggerAwareTrait;
use User\V1\VehicleUsersEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\Mapper\VehicleUsers as VehicleUsersMapper;
use User\Entity\VehicleUsers as VehicleUsersEntity;

class VehicleUsers
{
    use LoggerAwareTrait;
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\VehicleUsersEvent;
     */

    protected $vehicleUsersEvent;


    // public function __construct(VehicleUsersMapper $vehicleUsersMapper)
    // {
    //     $this->setVehicleUsersMapper($vehicleUsersMapper);
    // }

    public function __construct()
    {
    }

    /**
     * @return \User\V1\VehicleUsersEvent
     */
    public function getVehicleUsersEvent()
    {
        if ($this->vehicleUsersEvent == null) {
            $this->vehicleUsersEvent = new VehicleUsersEvent();
        }

        return $this->vehicleUsersEvent;
    }

    /**
     * @param VehicleUsersEvent $vehicleUsersEvent
     */
    public function setVehicleUsersEvent(VehicleUsersEvent $vehicleUsersEvent)
    {
        $this->vehicleUsersEvent = $vehicleUsersEvent;
    }

    /**
     * Update User VehicleUsers
     *
     * @param \User\Entity\VehicleUsers  $vehicleUsers
     * @param array                     $updateData
     */
    // public function update($vehicleusers, $inputFilter) //DITIRU DARI PROFILE
    // {
    //     $vehicleUsersEvent = $this->getVehicleUsersEvent();
    //     $vehicleUsersEvent->setVehicleUsersEntity($vehicleusers);
    //     $vehicleUsersEvent->setUpdateData($inputFilter->getValues());
    //     $vehicleUsersEvent->setInputFilter($inputFilter);
    //     $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_UPDATE_VEHICLE_USERS);
    //     $update = $this->getEventManager()->triggerEvent($vehicleUsersEvent);
    //     if ($update->stopped()) {
    //         $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_UPDATE_VEHICLE_USERS_ERROR);
    //         $vehicleUsersEvent->setException($update->last());
    //         $this->getEventManager()->triggerEvent($vehicleUsersEvent);
    //         throw $vehicleUsersEvent->getException();
    //     } else {
    //         $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_UPDATE_VEHICLE_USERS_SUCCESS);
    //         $this->getEventManager()->triggerEvent($vehicleUsersEvent);
    //     }
    // }

    public function save(ZendInputFilter $inputFilter)
    {
   // DITIRU DARI DEVICE
        $vehicleUsersEvent = new VehicleUsersEvent();
        $vehicleUsersEvent->setInputFilter($inputFilter);
        $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_CREATE_VEHICLEUSERS);
        $create = $this->getEventManager()->triggerEvent($vehicleUsersEvent);
        if ($create->stopped()) {
            $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_CREATE_VEHICLEUSERS_ERROR);
            $vehicleUsersEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($vehicleUsersEvent);
            throw $vehicleUsersEvent->getException();
        } else {
            $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_CREATE_VEHICLEUSERS_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleUsersEvent);
            return $vehicleUsersEvent->getVehicleUsersEntity();
        }
    }

    public function update(VehicleUsersEntity $vehicleUsers, ZendInputFilter $newData)
    {
        $vehicleUsersEvent = new VehicleUsersEvent();
        $vehicleUsersEvent->setInputFilter($newData);
        $vehicleUsersEvent->setUpdateData($newData->getValues());
        $vehicleUsersEvent->setVehicleUsersEntity($vehicleUsers);
        $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_UPDATE_VEHICLEUSERS);
        $update = $this->getEventManager()->triggerEvent($vehicleUsersEvent);
        if ($update->stopped()) {
            $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_UPDATE_VEHICLEUSERS_ERROR);
            $vehicleUsersEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($vehicleUsersEvent);
            throw $vehicleUsersEvent->getException();
        } else {
            // var_dump($vehicleUsersEvent);
            $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_UPDATE_VEHICLEUSERS_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleUsersEvent);
            return $vehicleUsersEvent->getVehicleUsersEntity();
        }
    }

    public function delete(VehicleUsersEntity $vehicleUsers)
    {
        $vehicleUsersEvent = new VehicleUsersEvent();
        $vehicleUsersEvent->setVehicleUsersEntity($vehicleUsers);
        $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_DELETE_VEHICLEUSERS);
        $delete = $this->getEventManager()->triggerEvent($vehicleUsersEvent);
        if ($delete->stopped()) {
            $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_DELETE_VEHICLEUSERS_ERROR);
            $vehicleUsersEvent->setException($delete->last());
            $this->getEventManager()->triggerEvent($vehicleUsersEvent);
            throw $vehicleUsersEvent->getException();
        } else {
            $vehicleUsersEvent->setName(VehicleUsersEvent::EVENT_DELETE_VEHICLEUSERS_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleUsersEvent);
            // return $vehicleUsersEvent->getVehicleUsersEntity();
            return true;  // => DISINI BEDANYA KALAU DELETE
        }
    }
}
