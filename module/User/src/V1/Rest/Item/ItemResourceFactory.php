<?php
namespace User\V1\Rest\Item;

class ItemResourceFactory
{
    public function __invoke($services)
    {
        // BELUM ADA SERVICE, MASIH FETCH DULU
        $itemMapper = $services->get(\User\Mapper\Item::class);
        $itemService = $services->get(\User\V1\Service\Item::class);
        $resource = new ItemResource($itemMapper);
        $resource->setItemService($itemService);
        return $resource;
    }
}
