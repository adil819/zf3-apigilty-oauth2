<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Entity\VehicleUsers as VehicleUsersEntity;
use User\V1\VehicleUsersEvent;

class VehicleUsersEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $config;

    protected $vehicleUsersMapper;

    protected $vehicleUsersHydrator;

    /**
     * Constructor
     *
     */
    public function __construct(\User\Mapper\VehicleUsers $vehicleUsersMapper)
    {
        $this->setVehicleUsersMapper($vehicleUsersMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            VehicleUsersEvent::EVENT_CREATE_VEHICLEUSERS,
            [$this, 'createVehicleUsers'],
            499
        );

        $this->listeners[] = $events->attach(
            VehicleUsersEvent::EVENT_UPDATE_VEHICLEUSERS,
            [$this, 'updateVehicle'],
            499
        );

        $this->listeners[] = $events->attach(
            VehicleUsersEvent::EVENT_DELETE_VEHICLEUSERS,
            [$this, 'deleteVehicle'],
            499
        );
    }

    # DITIRU DARI CREATEDEVICE()
    public function createVehicleUsers(VehicleUsersEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $vehicleUsersEntity = new VehicleUsersEntity;
            $vehicleUsers = $this->getVehicleUsersHydrator()->hydrate($data, $vehicleUsersEntity);

            $result = $this->getVehicleUsersMapper()->save($vehicleUsers);
            $event->setVehicleUsersEntity($vehicleUsers);
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
    public function updateVehicle(VehicleUsersEvent $event)
    {
        try {
            $vehicleUsersEntity = $event->getVehicleUsersEntity();
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
            $vehicleUsers = $this->getVehicleUsersHydrator()->hydrate($updateData, $vehicleUsersEntity);
            $result = $this->getVehicleUsersMapper()->save($vehicleUsers);
            $event->setVehicleUsersEntity($vehicleUsers);
            $uuid = $result->getUuid();
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} vehicle: {uuid} updated",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function deleteVehicle(VehicleUsersEvent $event)
    {
        try {
            $deletedData = $event->getVehicleUsersEntity();
            $this->getVehicleUsersMapper()->delete($deletedData);
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
     * @return the $vehicleUsersHydrator
     */
    public function getVehicleUsersHydrator()
    {
        return $this->vehicleUsersHydrator;
    }

    /**
     * @param DoctrineObject $vehicleHydrator
     */
    public function setVehicleUsersHydrator($vehicleUsersHydrator)
    {
        $this->vehicleUsersHydrator = $vehicleUsersHydrator;
    }



    /**
     * Get the value of vehicleUsersMapper
     */
    public function getVehicleUsersMapper()
    {
        return $this->vehicleUsersMapper;
    }

    /**
     * Set the value of vehicleUsersMapper
     *
     * @return  self
     */
    public function setVehicleUsersMapper($vehicleUsersMapper)
    {
        $this->vehicleUsersMapper = $vehicleUsersMapper;

        return $this;
    }
}
