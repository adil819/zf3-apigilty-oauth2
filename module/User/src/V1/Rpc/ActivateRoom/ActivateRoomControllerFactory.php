<?php
namespace User\V1\Rpc\ActivateRoom;

class ActivateRoomControllerFactory
{
    public function __invoke($controllers)
    {
        return new ActivateRoomController();
    }
}
