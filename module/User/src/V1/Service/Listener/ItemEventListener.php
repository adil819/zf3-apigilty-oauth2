<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\Item as ItemMapper;
use User\Entity\Item as ItemEntity;
use User\V1\ItemEvent;

class ItemEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $config;

    protected $itemMapper;

    protected $itemHydrator;

    /**
     * Constructor
     *
     * @param ItemMapper   $itemMapper
     * @param ItemHydrator $itemHydrator
     * @param array $config
     */
    public function __construct(
        ItemMapper $itemMapper
    ) {
        $this->setItemMapper($itemMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            ItemEvent::EVENT_CREATE_ITEM,
            [$this, 'createItem'],
            499
        );

        $this->listeners[] = $events->attach(
            ItemEvent::EVENT_UPDATE_ITEM,
            [$this, 'updateItem'],
            499
        );

        $this->listeners[] = $events->attach(
            ItemEvent::EVENT_DELETE_ITEM,
            [$this, 'deleteItem'],
            499
        );
    }

    # DITIRU DARI CREATEDEVICE()
    public function createItem(ItemEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $itemEntity = new ItemEntity;
            $item = $this->getItemHydrator()->hydrate($data, $itemEntity);

            $result = $this->getItemMapper()->save($item);
            $event->setItemEntity($item);
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
     * Update Item
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateItem(ItemEvent $event)
    {
        try {
            $itemEntity = $event->getItemEntity();
            $updateData  = $event->getUpdateData();
            // add file input filter here
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            // adding filter for photo
            // $inputPhoto  = $event->getInputFilter()->get('photo');
            // $inputPhoto->getFilterChain()
            //         ->attach(new \Zend\Filter\File\RenameUpload([
            //             'target' => $this->getConfig()['backup_dir'],
            //             'randomize' => true,
            //             'use_upload_extension' => true
            //         ]));
            $item = $this->getItemHydrator()->hydrate($updateData, $itemEntity);
            $this->getItemMapper()->save($item);
            $event->setItemEntity($item);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} item: {id} updated",
                [
                    "function" => __FUNCTION__,
                    "id" => $itemEntity->getUuid()
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function deleteItem(ItemEvent $event)
    {
        try {
            $deletedData = $event->getItemEntity();
            $this->getItemMapper()->delete($deletedData);
            $uuid = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data deleted successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    // public function deleteItem(ItemEvent $event)
    // {
    //     try {
    //         $itemEntity = $event->getItemEntity();

    //         $item = $this->getItemHydrator()->hydrate($itemEntity);
    //         $this->getItemMapper()->save($item);
    //         $event->setItemEntity($item);
    //         $this->logger->log(
    //             \Psr\Log\LogLevel::INFO,
    //             "{function} item: {id} deleted, name: {name}",
    //             [
    //                 "function" => __FUNCTION__,
    //                 "id" => $itemEntity->getUuid(),
    //                 "name" => $itemEntity->getName()
    //             ]
    //         );
    //     } catch (\Exception $e) {
    //         $event->stopPropagation(true);
    //         return $e;
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
     * @return the $itemMapper
     */
    public function getItemMapper()
    {
        return $this->itemMapper;
    }

    /**
     * @param ItemMapper $itemMapper
     */
    public function setItemMapper(ItemMapper $itemMapper)
    {
        $this->itemMapper = $itemMapper;
    }

    /**
     * @return the $itemHydrator
     */
    public function getItemHydrator()
    {
        return $this->itemHydrator;
    }

    /**
     * @param DoctrineObject $itemHydrator
     */
    public function setItemHydrator($itemHydrator)
    {
        $this->itemHydrator = $itemHydrator;
    }
}
