<?php
namespace User\V1\Service;

use PDO;
use Psr\Log\LoggerAwareTrait;
use User\V1\VehicleEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\Mapper\Vehicle as VehicleMapper;
use User\Entity\Vehicle as VehicleEntity;

class Vehicle
{
    use LoggerAwareTrait;
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\VehicleEvent;
     */

    protected $vehicleEvent;


    // public function __construct(VehicleMapper $vehicleMapper)
    // {
    //     $this->setVehicleMapper($vehicleMapper);
    // }

    public function __construct()
    {
    }

    /**
     * @return \User\V1\VehicleEvent
     */
    public function getVehicleEvent()
    {
        if ($this->vehicleEvent == null) {
            $this->vehicleEvent = new VehicleEvent();
        }

        return $this->vehicleEvent;
    }

    /**
     * @param VehicleEvent $vehicleEvent
     */
    public function setVehicleEvent(VehicleEvent $vehicleEvent)
    {
        $this->vehicleEvent = $vehicleEvent;
    }

    /**
     * Update User Vehicle
     *
     * @param \User\Entity\Vehicle  $vehicle
     * @param array                     $updateData
     */
    // public function update($vehicle, $inputFilter) //DITIRU DARI PROFILE
    // {
    //     $vehicleEvent = $this->getVehicleEvent();
    //     $vehicleEvent->setVehicleEntity($vehicle);
    //     $vehicleEvent->setUpdateData($inputFilter->getValues());
    //     $vehicleEvent->setInputFilter($inputFilter);
    //     $vehicleEvent->setName(VehicleEvent::EVENT_UPDATE_VEHICLE);
    //     $update = $this->getEventManager()->triggerEvent($vehicleEvent);
    //     if ($update->stopped()) {
    //         $vehicleEvent->setName(VehicleEvent::EVENT_UPDATE_VEHICLE_ERROR);
    //         $vehicleEvent->setException($update->last());
    //         $this->getEventManager()->triggerEvent($vehicleEvent);
    //         throw $vehicleEvent->getException();
    //     } else {
    //         $vehicleEvent->setName(VehicleEvent::EVENT_UPDATE_VEHICLE_SUCCESS);
    //         $this->getEventManager()->triggerEvent($vehicleEvent);
    //     }
    // }

    // public function register(array $vehicleData)  //DITIRU DARI SIGNUP
    // {
    //     $this->getVehicleEvent()->setVehicleData($vehicleData);
    //     $vehicleEvent = $this->getVehicleEvent();
    //     $vehicleEvent->setName(VehicleEvent::EVENT_INSERT_VEHICLE);
    //     $insert = $this->getEventManager()->triggerEvent($vehicleEvent);
    //     if ($insert->stopped()) {
    //         $vehicleEvent->setException($insert->last());
    //         $vehicleEvent->setName(VehicleEvent::EVENT_INSERT_VEHICLE_ERROR);
    //         $insert = $this->getEventManager()->triggerEvent($vehicleEvent);
    //         throw $this->getVehicleEvent()->getException();
    //     } else {
    //         $vehicleEvent->setName(VehicleEvent::EVENT_INSERT_VEHICLE_SUCCESS);
    //         $this->getEventManager()->triggerEvent($vehicleEvent);
    //     }
    // }

    public function save(ZendInputFilter $inputFilter)
    {
   // DITIRU DARI DEVICE
        $vehicleEvent = new VehicleEvent();
        $vehicleEvent->setInputFilter($inputFilter);
        $vehicleEvent->setName(VehicleEvent::EVENT_CREATE_VEHICLE);
        $create = $this->getEventManager()->triggerEvent($vehicleEvent);
        if ($create->stopped()) {
            $vehicleEvent->setName(VehicleEvent::EVENT_CREATE_VEHICLE_ERROR);
            $vehicleEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($vehicleEvent);
            throw $vehicleEvent->getException();
        } else {
            $vehicleEvent->setName(VehicleEvent::EVENT_CREATE_VEHICLE_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleEvent);
            return $vehicleEvent->getVehicleEntity();
        }
    }

    public function update(VehicleEntity $vehicle, ZendInputFilter $newData)
    {
        $vehicleEvent = new VehicleEvent();
        $vehicleEvent->setInputFilter($newData);
        $vehicleEvent->setUpdateData($newData->getValues());
        $vehicleEvent->setVehicleEntity($vehicle);
        $vehicleEvent->setName(VehicleEvent::EVENT_UPDATE_VEHICLE);
        $create = $this->getEventManager()->triggerEvent($vehicleEvent);
        if ($create->stopped()) {
            $vehicleEvent->setName(VehicleEvent::EVENT_UPDATE_VEHICLE_ERROR);
            $vehicleEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($vehicleEvent);
            throw $vehicleEvent->getException();
        } else {
            $vehicleEvent->setName(VehicleEvent::EVENT_UPDATE_VEHICLE_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleEvent);
            return $vehicleEvent->getVehicleEntity();
        }
    }

    public function delete(VehicleEntity $vehicle)
    {
        $vehicleEvent = new VehicleEvent();
        $vehicleEvent->setVehicleEntity($vehicle);
        $vehicleEvent->setName(VehicleEvent::EVENT_DELETE_VEHICLE);
        $delete = $this->getEventManager()->triggerEvent($vehicleEvent);
        if ($delete->stopped()) {
            $vehicleEvent->setName(VehicleEvent::EVENT_DELETE_VEHICLE_ERROR);
            $vehicleEvent->setException($delete->last());
            $this->getEventManager()->triggerEvent($vehicleEvent);
            throw $vehicleEvent->getException();
        } else {
            $vehicleEvent->setName(VehicleEvent::EVENT_DELETE_VEHICLE_SUCCESS);
            $this->getEventManager()->triggerEvent($vehicleEvent);
            // return $vehicleEvent->getVehicleEntity();
            return true;  // => DISINI BEDANYA KALAU DELETE
        }
    }
}
