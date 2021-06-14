<?php
namespace User\V1\Rest\Room;

class RoomResourceFactory
{
    public function __invoke($services)
    {
        // $roomMapper = $services->get('User\Mapper\Room');
        $roomMapper = $services->get(\User\Mapper\Room::class);
        $roomService = $services->get(\User\V1\Service\Room::class);
        $resource = new RoomResource($roomMapper);
        $resource->setRoomService($roomService);
        return $resource;
    }
}
