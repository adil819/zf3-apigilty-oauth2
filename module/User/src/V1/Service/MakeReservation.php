<?php
namespace User\V1\Service;

use User\V1\MakeReservationEvent;
use Zend\EventManager\EventManagerAwareTrait;

class MakeReservation
{
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\MakeReservationEvent
     */
    protected $makeReservationEvent;

    public function __construct()
    {
    }

    /**
     * @return $signupEvent
     */
    public function getMakeReservationEvent()
    {
        if ($this->makeReservationEvent == null) {
            $this->makeReservationEvent = new MakeReservationEvent();
        }

        return $this->makeReservationEvent;
    }

    /**
     * @param MakeReservationEvent $MakeReservationEvent
     */
    public function setMakeReservationEvent(MakeReservationEvent $makeReservationEvent)
    {
        $this->makeReservationEvent = $makeReservationEvent;
    }

    /**
     * Register new user
     *
     * @param  array $makeReservationEventData
     * @throw  \RuntimeException
     * @return void
     */
    public function register(array $makeReservationData)
    {
        $this->getMakeReservationEvent()->setMakeReservationData($makeReservationData);
        $makeReservationEvent = $this->getMakeReservationEvent();
        $makeReservationEvent->setName(MakeReservationEvent::EVENT_INSERT_ROOMUSERS);
        $insert = $this->getEventManager()->triggerEvent($makeReservationEvent);
        if ($insert->stopped()) {
            $makeReservationEvent->setException($insert->last());
            $makeReservationEvent->setName(MakeReservationEvent::EVENT_INSERT_ROOMUSERS_ERROR);
            $insert = $this->getEventManager()->triggerEvent($makeReservationEvent);
            throw $this->getMakeReservationEvent()->getException();
        } else {
            $makeReservationEvent->setName(MakeReservationEvent::EVENT_INSERT_ROOMUSERS_SUCCESS);
            $this->getEventManager()->triggerEvent($makeReservationEvent);
        }
    }
}
