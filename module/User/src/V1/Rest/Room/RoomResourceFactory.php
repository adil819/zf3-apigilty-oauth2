<?php
namespace User\V1\Rest\Room;

class RoomResourceFactory
{
    public function __invoke($services)
    {
        $roomMapper = $services->get('User\Mapper\Room');
        // $room = $services->get('room'); // ATAU MUNGKIN get('user.room')
        return new RoomResource($roomMapper);
    }
}
