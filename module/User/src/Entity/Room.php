<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timestampable\Traits\Timestampable as TimestampableTrait;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable as SoftDeleteableTrait;

/**
 * UserProfile
 */
class Room implements EntityInterface
{
    use TimestampableTrait;

    use SoftDeleteableTrait;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $capacity;

    // /**
    //  * @var DateTime
    //  */
    // private $dateOfBirth;

    /**
     * @return the $uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * Get capacity
     *
     * @return integer
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    // /**
    //  * @return the $dateOfBirth
    //  */
    // public function getDateOfBirth()
    // {
    //     return $this->dateOfBirth;
    // }

    // /**
    //  * @param \DateTime $dateOfBirth
    //  */
    // public function setDateOfBirth($dateOfBirth)
    // {
    //     $this->dateOfBirth = $dateOfBirth;
    // }
}
