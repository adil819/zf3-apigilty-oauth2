<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timestampable\Traits\Timestampable as TimestampableTrait;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable as SoftDeleteableTrait;

/**
 * RoomUsers
 */
class RoomUsers implements EntityInterface
{
    use TimestampableTrait;

    use SoftDeleteableTrait;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \User\Entity\Room
     */
    private $room;

    /**
     * @var \User\Entity\UserProfile
     */
    private $userProfile;

    /**
     * @var DateTime
     */
    private $reservationTime;

    /**
     * @var boolean
     */
    private $isActive = false;

    /**
     * @return the $uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return the $isActive
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get the value of reservationTime
     */
    public function getReservationTime()
    {
        return $this->reservationTime;
    }

    /**
     * Set the value of reservationTime
     */
    public function setReservationTime($reservationTime): self
    {
        $this->reservationTime = $reservationTime;

        return $this;
    }

    /**
     * Get the value of room
     *
     * @return  \User\Entity\Room
     */ 
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set the value of room
     *
     * @param  \User\Entity\Room  $room
     *
     * @return  self
     */ 
    public function setRoom(\User\Entity\Room $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get the value of userProfile
     *
     * @return  \User\Entity\UserProfile
     */ 
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set the value of userProfile
     *
     * @param  \User\Entity\UserProfile  $userProfile
     *
     * @return  self
     */ 
    public function setUserProfile(\User\Entity\UserProfile $userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }
}
