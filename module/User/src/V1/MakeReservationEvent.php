<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\ORM\Entity\EntityInterface;

class MakeReservationEvent extends Event
{
    /**#@+
     * Makereservation events triggered by eventmanager
     */
    const EVENT_INSERT_ROOMUSERS = 'insert.roomusers';
    const EVENT_INSERT_ROOMUSERS_SUCCESS = 'insert.roomusers.success';
    const EVENT_INSERT_ROOMUSERS_ERROR   = 'insert.roomusers.error';
    /**#@-*/

    /**
     * @var Aqilix\ORM\Entity\EntityInterface
     */
    protected $userEntity;

    /**
     * @var array
     */
    protected $makeReservationData;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @return the $user
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     * @param Aqilix\ORM\Entity\EntityInterface $user
     */
    public function setUserEntity(EntityInterface $user)
    {
        $this->userEntity = $user;
    }

    /**
     * @return the $makereservationData
     */
    public function getMakeReservationData()
    {
        return $this->makeReservationData;
    }

    /**
     * @param Array $makereservationData
     */
    public function setMakeReservationData(array $makeReservationData)
    {
        $this->makeReservationData = $makeReservationData;
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
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }
}
