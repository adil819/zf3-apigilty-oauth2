<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\Vehicle as VehicleMapper;
use User\Entity\Vehicle as VehicleEntity;
use User\V1\VehicleEvent;

class VehicleEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $config;

    protected $vehicleMapper;

    protected $vehicleHydrator;

    /**
     * Constructor
     *
     * @param VehicleMapper   $vehicleMapper
     * @param VehicleHydrator $vehicleHydrator
     * @param array $config
     */
    public function __construct(
        VehicleMapper $vehicleMapper
    ) {
        $this->setVehicleMapper($vehicleMapper); 
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            VehicleEvent::EVENT_CREATE_VEHICLE,
            [$this, 'createVehicle'],
            499
        );

        $this->listeners[] = $events->attach(
            VehicleEvent::EVENT_UPDATE_VEHICLE,
            [$this, 'updateVehicle'],
            499
        );

        $this->listeners[] = $events->attach(
            VehicleEvent::EVENT_DELETE_VEHICLE,
            [$this, 'deleteVehicle'],
            499
        );
    }
    
    # DITIRU DARI CREATEDEVICE()
    public function createVehicle(VehicleEvent $event){
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface){
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $vehicleEntity = new VehicleEntity;
            $vehicle = $this->getVehicleHydrator()->hydrate($data, $vehicleEntity);
            
            $result = $this->getVehicleMapper()->save($vehicle);
            $event->setVehicleEntity($vehicle);
            $uuid = $result->getUuid();
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: New data created successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        } 
    }

    /**
     * Update Vehicle
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateVehicle(VehicleEvent $event)
    {
        try {
            $vehicleEntity = $event->getVehicleEntity();
            $updateData  = $event->getUpdateData();
            // add file input filter here
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            // adding filter for photo
            // $inputPhoto  = $event->getInputFilter()->get('photo');
            // $inputPhoto->getFilterChain()
            //         ->attach(new \Zend\Filter\File\RenameUpload([
            //             'target' => $this->getConfig()['backup_dir'],
            //             'randomize' => true,
            //             'use_upload_extension' => true
            //         ]));
            $vehicle = $this->getVehicleHydrator()->hydrate($updateData, $vehicleEntity);
            $this->getVehicleMapper()->save($vehicle);
            $event->setVehicleEntity($vehicle);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} vehicle: {id} updated, capacity: {caps}",
                [
                    "function" => __FUNCTION__,
                    "id" => $vehicleEntity->getUuid(),
                    "caps" => $vehicleEntity->getCapacity()
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function deleteVehicle(VehicleEvent $event)
    {
        try {
            $deletedData = $event->getVehicleEntity();
            $this->getVehicleMapper()->delete($deletedData);
            $uuid = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data deleted successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    // public function deleteVehicle(VehicleEvent $event)
    // {
    //     try {
    //         $vehicleEntity = $event->getVehicleEntity();
  
    //         $vehicle = $this->getVehicleHydrator()->hydrate($vehicleEntity);
    //         $this->getVehicleMapper()->save($vehicle);
    //         $event->setVehicleEntity($vehicle);
    //         $this->logger->log(
    //             \Psr\Log\LogLevel::INFO,
    //             "{function} vehicle: {id} deleted, name: {name}",
    //             [
    //                 "function" => __FUNCTION__,
    //                 "id" => $vehicleEntity->getUuid(),
    //                 "name" => $vehicleEntity->getName()
    //             ]
    //         );
    //     } catch (\Exception $e) {
    //         $event->stopPropagation(true);
    //         return $e;
    //     }
    // }

    /**
     * @return the $config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return the $vehicleMapper
     */
    public function getVehicleMapper()
    {
        return $this->vehicleMapper;
    }

    /**
     * @param VehicleMapper $vehicleMapper
     */
    public function setVehicleMapper(VehicleMapper $vehicleMapper)
    {
        $this->vehicleMapper = $vehicleMapper;
    }

    /**
     * @return the $vehicleHydrator
     */
    public function getVehicleHydrator()
    {
        return $this->vehicleHydrator;
    }

    /**
     * @param DoctrineObject $vehicleHydrator
     */
    public function setVehicleHydrator($vehicleHydrator)
    {
        $this->vehicleHydrator = $vehicleHydrator;
    }


}
