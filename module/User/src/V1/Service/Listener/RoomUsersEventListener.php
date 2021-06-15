<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Entity\RoomUsers as RoomUsersEntity;
use User\V1\RoomUsersEvent;

class RoomUsersEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $config;

    protected $roomUsersMapper;

    protected $roomUsersHydrator;

    /**
     * Constructor
     *
     */
    public function __construct(\User\Mapper\RoomUsers $roomUsersMapper) {
        $this->setRoomUsersMapper($roomUsersMapper);         
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            RoomUsersEvent::EVENT_CREATE_ROOMUSERS,
            [$this, 'createRoomUsers'],
            499
        );

        // $this->listeners[] = $events->attach(
        //     RoomUsersEvent::EVENT_UPDATE_ROOM_USERS,
        //     [$this, 'updateRoom'],
        //     499
        // );

        // $this->listeners[] = $events->attach(
        //     RoomUsersEvent::EVENT_DELETE_ROOM_USERS,
        //     [$this, 'deleteRoom'],
        //     499
        // );
    }
    
    # DITIRU DARI CREATEDEVICE()
    public function createRoomUsers(RoomUsersEvent $event){
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface){
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $roomUsersEntity = new RoomUsersEntity;
            $roomUsers = $this->getRoomUsersHydrator()->hydrate($data, $roomUsersEntity);
            
            $result = $this->getRoomUsersMapper()->save($roomUsers);
            $event->setRoomUsersEntity($roomUsers);
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
    // public function updateRoom(RoomEvent $event)
    // {
    //     try {
    //         $roomEntity = $event->getRoomEntity();
    //         $updateData  = $event->getUpdateData();
    //         // add file input filter here
    //         if (! $event->getInputFilter() instanceof InputFilterInterface) {
    //             throw new InvalidArgumentException('Input Filter not set');
    //         }

    //         // adding filter for photo
    //         // $inputPhoto  = $event->getInputFilter()->get('photo');
    //         // $inputPhoto->getFilterChain()
    //         //         ->attach(new \Zend\Filter\File\RenameUpload([
    //         //             'target' => $this->getConfig()['backup_dir'],
    //         //             'randomize' => true,
    //         //             'use_upload_extension' => true
    //         //         ]));
    //         $room = $this->getRoomHydrator()->hydrate($updateData, $roomEntity);
    //         $this->getRoomMapper()->save($room);
    //         $event->setRoomEntity($room);
    //         $this->logger->log(
    //             \Psr\Log\LogLevel::INFO,
    //             "{function} room: {id} updated, capacity: {caps}",
    //             [
    //                 "function" => __FUNCTION__,
    //                 "id" => $roomEntity->getUuid(),
    //                 "caps" => $roomEntity->getCapacity()
    //             ]
    //         );
    //     } catch (\Exception $e) {
    //         $event->stopPropagation(true);
    //         return $e;
    //     }
    // }

    // public function deleteRoom(RoomEvent $event)
    // {
    //     try {
    //         $deletedData = $event->getRoomEntity();
    //         $this->getRoomMapper()->delete($deletedData);
    //         $uuid = $deletedData->getUuid();

    //         $this->logger->log(
    //             \Psr\Log\LogLevel::INFO,
    //             "{function} {uuid}: Data deleted successfully",
    //             [
    //                 'uuid' => $uuid,
    //                 "function" => __FUNCTION__
    //             ]
    //         );
    //     } catch (\Exception $e) {
    //         $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
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
     * @return the $roomUsersHydrator
     */
    public function getRoomUsersHydrator()
    {
        return $this->roomUsersHydrator;
    }

    /**
     * @param DoctrineObject $roomHydrator
     */
    public function setRoomUsersHydrator($roomUsersHydrator)
    {
        $this->roomUsersHydrator = $roomUsersHydrator;
    }



    /**
     * Get the value of roomUsersMapper
     */ 
    public function getRoomUsersMapper()
    {
        return $this->roomUsersMapper;
    }

    /**
     * Set the value of roomUsersMapper
     *
     * @return  self
     */ 
    public function setRoomUsersMapper($roomUsersMapper)
    {
        $this->roomUsersMapper = $roomUsersMapper;

        return $this;
    }
}
