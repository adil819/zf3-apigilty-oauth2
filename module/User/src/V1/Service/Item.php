<?php
namespace User\V1\Service;

use PDO;
use Psr\Log\LoggerAwareTrait;
use User\V1\ItemEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\Mapper\Item as ItemMapper;
use User\Entity\Item as ItemEntity;

class Item
{
    use LoggerAwareTrait;
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\ItemEvent;
     */

    protected $itemEvent;


    // public function __construct(ItemMapper $itemMapper)
    // {
    //     $this->setItemMapper($itemMapper);
    // }

    public function __construct()
    {
    }

    /**
     * @return \User\V1\ItemEvent
     */
    public function getItemEvent()
    {
        if ($this->itemEvent == null) {
            $this->itemEvent = new ItemEvent();
        }

        return $this->itemEvent;
    }

    /**
     * @param ItemEvent $itemEvent
     */
    public function setItemEvent(ItemEvent $itemEvent)
    {
        $this->itemEvent = $itemEvent;
    }

    /**
     * Update User Item
     *
     * @param \User\Entity\Item  $item
     * @param array                     $updateData
     */
    // public function update($item, $inputFilter) //DITIRU DARI PROFILE
    // {
    //     $itemEvent = $this->getItemEvent();
    //     $itemEvent->setItemEntity($item);
    //     $itemEvent->setUpdateData($inputFilter->getValues());
    //     $itemEvent->setInputFilter($inputFilter);
    //     $itemEvent->setName(ItemEvent::EVENT_UPDATE_ITEM);
    //     $update = $this->getEventManager()->triggerEvent($itemEvent);
    //     if ($update->stopped()) {
    //         $itemEvent->setName(ItemEvent::EVENT_UPDATE_ITEM_ERROR);
    //         $itemEvent->setException($update->last());
    //         $this->getEventManager()->triggerEvent($itemEvent);
    //         throw $itemEvent->getException();
    //     } else {
    //         $itemEvent->setName(ItemEvent::EVENT_UPDATE_ITEM_SUCCESS);
    //         $this->getEventManager()->triggerEvent($itemEvent);
    //     }
    // }

    public function register(array $itemData)  //DITIRU DARI SIGNUP
    {
        $this->getItemEvent()->setItemData($itemData);
        $itemEvent = $this->getItemEvent();
        $itemEvent->setName(ItemEvent::EVENT_INSERT_ITEM);
        $insert = $this->getEventManager()->triggerEvent($itemEvent);
        if ($insert->stopped()) {
            $itemEvent->setException($insert->last());
            $itemEvent->setName(ItemEvent::EVENT_INSERT_ITEM_ERROR);
            $insert = $this->getEventManager()->triggerEvent($itemEvent);
            throw $this->getItemEvent()->getException();
        } else {
            $itemEvent->setName(ItemEvent::EVENT_INSERT_ITEM_SUCCESS);
            $this->getEventManager()->triggerEvent($itemEvent);
        }
    }

    public function save(ZendInputFilter $inputFilter)
    {
   // DITIRU DARI DEVICE
        $itemEvent = new ItemEvent();
        $itemEvent->setInputFilter($inputFilter);
        $itemEvent->setName(ItemEvent::EVENT_CREATE_ITEM);
        $create = $this->getEventManager()->triggerEvent($itemEvent);
        if ($create->stopped()) {
            $itemEvent->setName(ItemEvent::EVENT_CREATE_ITEM_ERROR);
            $itemEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($itemEvent);
            throw $itemEvent->getException();
        } else {
            $itemEvent->setName(ItemEvent::EVENT_CREATE_ITEM_SUCCESS);
            $this->getEventManager()->triggerEvent($itemEvent);
            return $itemEvent->getItemEntity();
        }
    }

    public function update(ItemEntity $item, ZendInputFilter $newData)
    {
        $itemEvent = new ItemEvent();
        $itemEvent->setInputFilter($newData);
        $itemEvent->setUpdateData($newData->getValues());
        $itemEvent->setItemEntity($item);
        $itemEvent->setName(ItemEvent::EVENT_UPDATE_ITEM);
        $create = $this->getEventManager()->triggerEvent($itemEvent);
        if ($create->stopped()) {
            $itemEvent->setName(ItemEvent::EVENT_UPDATE_ITEM_ERROR);
            $itemEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($itemEvent);
            throw $itemEvent->getException();
        } else {
            $itemEvent->setName(ItemEvent::EVENT_UPDATE_ITEM_SUCCESS);
            $this->getEventManager()->triggerEvent($itemEvent);
            return $itemEvent->getItemEntity();
        }
    }

    public function delete(ItemEntity $item)
    {
        $itemEvent = new ItemEvent();
        $itemEvent->setItemEntity($item);
        $itemEvent->setName(ItemEvent::EVENT_DELETE_ITEM);
        $delete = $this->getEventManager()->triggerEvent($itemEvent);
        if ($delete->stopped()) {
            $itemEvent->setName(ItemEvent::EVENT_DELETE_ITEM_ERROR);
            $itemEvent->setException($delete->last());
            $this->getEventManager()->triggerEvent($itemEvent);
            throw $itemEvent->getException();
        } else {
            $itemEvent->setName(ItemEvent::EVENT_DELETE_ITEM_SUCCESS);
            $this->getEventManager()->triggerEvent($itemEvent);
            // return $itemEvent->getItemEntity();
            return true;  // => DISINI BEDANYA KALAU DELETE
        }
    }
}
