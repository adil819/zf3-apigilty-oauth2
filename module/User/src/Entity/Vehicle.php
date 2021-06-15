<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timestampable\Traits\Timestampable as TimestampableTrait;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable as SoftDeleteableTrait;

/**
 * UserProfile
 */
class Vehicle implements EntityInterface
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
    private $brand;

    /**
     * @var integer
     */
    private $wheel;

    /**
     * @var integer
     */
    private $productionYear;

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
     * Set brand
     *
     * @param string $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Get the value of wheel
     */
    public function getWheel()
    {
        return $this->wheel;
    }

    /**
     * Set the value of wheel
     */
    public function setWheel($wheel): self
    {
        $this->wheel = $wheel;

        return $this;
    }

    /**
     * Get the value of productionYear
     */
    public function getProductionYear()
    {
        return $this->productionYear;
    }

    /**
     * Set the value of productionYear
     */
    public function setProductionYear($productionYear): self
    {
        $this->productionYear = $productionYear;

        return $this;
    }
}
