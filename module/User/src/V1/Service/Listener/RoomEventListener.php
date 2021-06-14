<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\Room as RoomMapper;
use User\Entity\Room as RoomEntity;
use User\V1\RoomEvent;

class RoomEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $config;

    protected $roomMapper;

    protected $roomHydrator;

    /**
     * Constructor
     *
     * @param RoomMapper   $roomMapper
     * @param RoomHydrator $roomHydrator
     * @param array $config
     */
    public function __construct(
        RoomMapper $roomMapper
    ) {
        $this->setRoomMapper($roomMapper); 
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            RoomEvent::EVENT_CREATE_ROOM,
            [$this, 'createRoom'],
            499
        );

        $this->listeners[] = $events->attach(
            RoomEvent::EVENT_UPDATE_ROOM,
            [$this, 'updateRoom'],
            499
        );

        $this->listeners[] = $events->attach(
            RoomEvent::EVENT_DELETE_ROOM,
            [$this, 'deleteRoom'],
            499
        );
    }
    
    # DITIRU DARI CREATEDEVICE()
    public function createRoom(RoomEvent $event){
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface){
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $roomEntity = new RoomEntity;
            $room = $this->getRoomHydrator()->hydrate($data, $roomEntity);
            
            $result = $this->getRoomMapper()->save($room);
            $event->setRoomEntity($room);
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
     * Update Room
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateRoom(RoomEvent $event)
    {
        try {
            $roomEntity = $event->getRoomEntity();
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
            $room = $this->getRoomHydrator()->hydrate($updateData, $roomEntity);
            $this->getRoomMapper()->save($room);
            $event->setRoomEntity($room);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} room: {id} updated, capacity: {caps}",
                [
                    "function" => __FUNCTION__,
                    "id" => $roomEntity->getUuid(),
                    "caps" => $roomEntity->getCapacity()
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function deleteRoom(RoomEvent $event)
    {
        try {
            $deletedData = $event->getRoomEntity();
            $this->getRoomMapper()->delete($deletedData);
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

    // public function deleteRoom(RoomEvent $event)
    // {
    //     try {
    //         $roomEntity = $event->getRoomEntity();
  
    //         $room = $this->getRoomHydrator()->hydrate($roomEntity);
    //         $this->getRoomMapper()->save($room);
    //         $event->setRoomEntity($room);
    //         $this->logger->log(
    //             \Psr\Log\LogLevel::INFO,
    //             "{function} room: {id} deleted, name: {name}",
    //             [
    //                 "function" => __FUNCTION__,
    //                 "id" => $roomEntity->getUuid(),
    //                 "name" => $roomEntity->getName()
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
     * @return the $roomMapper
     */
    public function getRoomMapper()
    {
        return $this->roomMapper;
    }

    /**
     * @param RoomMapper $roomMapper
     */
    public function setRoomMapper(RoomMapper $roomMapper)
    {
        $this->roomMapper = $roomMapper;
    }

    /**
     * @return the $roomHydrator
     */
    public function getRoomHydrator()
    {
        return $this->roomHydrator;
    }

    /**
     * @param DoctrineObject $roomHydrator
     */
    public function setRoomHydrator($roomHydrator)
    {
        $this->roomHydrator = $roomHydrator;
    }


}
