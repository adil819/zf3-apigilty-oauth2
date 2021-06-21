<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Psr\Log\LoggerAwareTrait;
use User\Entity\RoomUsers as RoomUsersEntity;
use User\Mapper\RoomUsers as RoomUsersMapper;
use User\V1\MakeReservationEvent;

class MakeReservationEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $roomUsersMapper;
    protected $roomUsersHydrator;

    /**
     * Constructor
     *
     * @param RoomUsersMapper $roomUsersMapper
     */
    public function __construct(
        RoomUsersMapper $roomUsersMapper
    ) {
        $this->roomUsersMapper  = $roomUsersMapper;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MakeReservationEvent::EVENT_INSERT_ROOMUSERS,
            [$this, 'createRoomUsers'],
            499
        );
    }

    /**
     * Create Room Users
     *
     * @param  MakeReservationEvent $event
     * @return void|\Exception
     */
    public function createRoomUsers(MakeReservationEvent $event)
    {
        try {
            $makeReservationData = $event->getMakeReservationData();
            $roomUsers = new \User\Entity\RoomUsers;

            // KESALAHANNYA DISINI, UNCOMMENT RESERVATION TIME JADINYA MALAH NULL 

            // var_dump($makeReservationData['reservationTime']);exit();
            $roomUsersEntity = new RoomUsersEntity;
            $roomUsers = $this->getRoomUsersHydrator()->hydrate($makeReservationData, $roomUsersEntity);
            $this->getRoomUsersMapper()->save($roomUsers);
            // $event->setRoomUsersEntity($roomUser);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}",
                ["function" => __FUNCTION__, "uuid" => $roomUsers->getUuid()]
            );
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
            $event->stopPropagation(true);
            return $e;
        }
    }

    /**
     * @return the $roomUsersMapper
     */
    public function getRoomUsersMapper()
    {
        return $this->roomUsersMapper;
    }

    /**
     * @param RoomUsersMapper $roomUsersMapper
     */
    public function setRoomUsersMapper(RoomUsersMapper $roomUsersMapper)
    {
        $this->roomUsersMapper = $roomUsersMapper;
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
}
