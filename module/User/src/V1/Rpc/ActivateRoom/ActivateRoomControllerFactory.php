<?php
namespace User\V1\Rpc\ActivateRoom;

class ActivateRoomControllerFactory
{
    public function __invoke($controllers)
    {
        $activateRoomValidator = $controllers->get('InputFilterManager')->get('User\\V1\\Rpc\\ActivateRoom\\Validator');
        $activateRoomService = $controllers->get('user.activate-room');
        // var_dump($this->activateRoomValidator);exit();
        $roomUsersMapper = $controllers->get(\User\Mapper\RoomUsers::class);
        return new ActivateRoomController($roomUsersMapper, $activateRoomService, $activateRoomValidator);
    }
}
