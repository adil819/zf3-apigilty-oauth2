<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\ORM\Entity\EntityInterface;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class ItemEvent extends Event
{
    /**#@+
     * Item events triggered by eventmanager
     */
    # UPDATE DITIRU DARI PROFILE
    const EVENT_UPDATE_ITEM  = 'update.item';
    const EVENT_UPDATE_ITEM_ERROR   = 'update.item.error';
    const EVENT_UPDATE_ITEM_SUCCESS = 'update.item.success';

    #INSERT DITIRU DARI SIGNUP
    const EVENT_INSERT_ITEM  = 'insert.item';
    const EVENT_INSERT_ITEM_ERROR   = 'insert.item.error';
    const EVENT_INSERT_ITEM_SUCCESS = 'insert.item.success';

    #CREATE DITIRU DARI DEVICE
    const EVENT_CREATE_ITEM  = 'create.item';
    const EVENT_CREATE_ITEM_ERROR   = 'create.item.error';
    const EVENT_CREATE_ITEM_SUCCESS = 'create.item.success';

    #DELETE BUAT SENDIRI TANPA CONTEK DENGAN MENGINGAT ALUR NYA
    const EVENT_DELETE_ITEM = 'delete.item';
    const EVENT_DELETE_ITEM_ERROR = 'delete.item.error';
    const EVENT_DELETE_ITEM_SUCCESS = 'delete.item.success';

    /**#@-*/

    /**
     * @var User\Entity\UserItem
     */
    protected $itemEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var array
     */
    protected $updateData;

    /**
     * @var \Exception
     */
    protected $exception;

    // INI DIMODIFIKASI DARI SignupEvent
    /**
     * @param Array $itemData
     */
    public function setItemData(array $itemData)
    {
        $this->itemData = $itemData;
    }

    /**
     * @return the $updateData
     */
    public function getUpdateData()
    {
        return $this->updateData;
    }

    /**
     * @param object $updateData
     */
    public function setUpdateData($updateData)
    {
        $this->updateData = $updateData;
    }

    /**
     * @return the $inputFilter
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * @param Zend\InputFilter\InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
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
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * Get the value of itemEntity
     */
    public function getItemEntity()
    {
        return $this->itemEntity;
    }

    /**
     * Set the value of itemEntity
     */
    public function setItemEntity($itemEntity): self
    {
        $this->itemEntity = $itemEntity;

        return $this;
    }
}
