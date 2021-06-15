<?php
namespace User\V1\Rest\RoomUsers;

class RoomUsersResourceFactory
{
    public function __invoke($services)
    {
        $roomUsersMapper = $services->get(\User\Mapper\RoomUsers::class);
        $roomUsersService = $services->get(\User\V1\Service\RoomUsers::class);
        $resource = new RoomUsersResource($roomUsersMapper);
        $resource->setRoomUsersService($roomUsersService);
        return $resource;
    }
}
