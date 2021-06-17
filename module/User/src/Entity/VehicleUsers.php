<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timestampable\Traits\Timestampable as TimestampableTrait;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable as SoftDeleteableTrait;

/**
 * VehicleUsers
 */
class VehicleUsers implements EntityInterface
{
    use TimestampableTrait;

    use SoftDeleteableTrait;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \User\Entity\Vehicle
     */
    private $vehicle;

    /**
     * @var \User\Entity\UserProfile
     */
    private $userProfile;

    /**
     * @var DateTime
     */
    private $bookingDay;

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
     * Get the value of bookingDay
     */
    public function getBookingDay()
    {
        return $this->bookingDay;
    }

    /**
     * Set the value of bookingDay
     */
    public function setBookingDay($bookingDay): self
    {
        $this->bookingDay = $bookingDay;

        return $this;
    }

    /**
     * Get the value of vehicle
     *
     * @return  \User\Entity\Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set the value of vehicle
     *
     * @param  \User\Entity\Vehicle  $vehicle
     *
     * @return  self
     */
    public function setVehicle(\User\Entity\Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;

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
