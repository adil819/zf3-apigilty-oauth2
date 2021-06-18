<?php
namespace User\V1\Rpc\UserRoomStats;

class UserRoomStatsControllerFactory
{
    public function __invoke($controllers)
    {
        $authentication = $controllers->get('authentication');
        $email = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $user = $controllers->get('User\Mapper\UserProfile')->fetchOneBy(['user' => $email]);


        $userProfile = $controllers->get(\User\Mapper\UserProfile::class);
        $room = $controllers->get(\User\Mapper\Room::class);
        $roomUsersMapper = $controllers->get(\User\Mapper\RoomUsers::class);
        $controller = new UserRoomStatsController(
            $user,
            $userProfile,
            $room,
            $roomUsersMapper
        );
        return $controller;
    }
}
