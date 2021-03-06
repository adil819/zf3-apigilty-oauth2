<?php
namespace User;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Mvc\MvcEvent;
use ZF\MvcAuth\MvcAuthEvent;

class Module implements
    ApigilityProviderInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ConsoleUsageProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        // signup
        $signupService  = $serviceManager->get('user.signup');
        $signupEventListener = $serviceManager->get('user.signup.listener');
        $signupEventListener->attach($signupService->getEventManager());
        // user activation
        $userActivationService = $serviceManager->get('user.activation');
        $userActivationEventListener = $serviceManager->get('user.activation.listener');
        $userActivationEventListener->attach($userActivationService->getEventManager());
        // user room stats
        // $userRoomStatsService = $serviceManager->get('user.room.stats');
        // $userRoomStatsEventListener = $serviceManager->get('user.room.stats.listener');
        // $userRoomStatsEventListener->attach($userRoomStatsService->getEventManager());
        // profile
        $profileEventListener = $serviceManager->get('user.profile.listener');
        $profileService = $serviceManager->get('user.profile');
        $profileEventListener->attach($profileService->getEventManager());

        // Room event listener
        $roomEventListener = $serviceManager->get(\User\V1\Service\Listener\RoomEventListener::class);
        $roomService = $serviceManager->get(\User\V1\Service\Room::class);
        $roomEventListener->attach($roomService->getEventManager());

        // Item event listener
        $itemEventListener = $serviceManager->get(\User\V1\Service\Listener\ItemEventListener::class);
        $itemService = $serviceManager->get(\User\V1\Service\Item::class);
        $itemEventListener->attach($itemService->getEventManager());

        // Vehicle event listener
        $vehicleEventListener = $serviceManager->get(\User\V1\Service\Listener\VehicleEventListener::class);
        $vehicleService = $serviceManager->get(\User\V1\Service\Vehicle::class);
        $vehicleEventListener->attach($vehicleService->getEventManager());

        // Room Users event listener
        $roomUsersEventListener = $serviceManager->get(\User\V1\Service\Listener\RoomUsersEventListener::class);
        $roomUsersService = $serviceManager->get(\User\V1\Service\RoomUsers::class);
        $roomUsersEventListener->attach($roomUsersService->getEventManager());
        // makeReservation
        $makeReservationService  = $serviceManager->get('user.make-reservation');
        $makeReservationEventListener = $serviceManager->get('user.make-reservation.listener');
        $makeReservationEventListener->attach($makeReservationService->getEventManager());
        // activateRoom
        $activateRoomService  = $serviceManager->get('user.activate-room');
        $activateRoomEventListener = $serviceManager->get('user.activate-room.listener');
        $activateRoomEventListener->attach($activateRoomService->getEventManager());

        // Vehicle Users event listener
        $vehicleUsersEventListener = $serviceManager->get(\User\V1\Service\Listener\VehicleUsersEventListener::class);
        $vehicleUsersService = $serviceManager->get(\User\V1\Service\VehicleUsers::class);
        $vehicleUsersEventListener->attach($vehicleUsersService->getEventManager());

        // reset password
        $resetPasswordService = $serviceManager->get('user.resetpassword');
        $resetPasswordEventListener = $serviceManager->get('user.resetpassword.listener');
        $resetPasswordEventListener->attach($resetPasswordService->getEventManager());
        // AuthActiveUserListener
        $app    = $mvcEvent->getApplication();
        $events = $app->getEventManager();
        $mvcAuthEvent = new MvcAuthEvent(
            $mvcEvent,
            $serviceManager->get('authentication'),
            $serviceManager->get('authorization')
        );
        $pdoAdapter = $serviceManager->get('user.auth.pdo.adapter');
        $pdoAdapter->setEventManager($events);
        $pdoAdapter->setMvcAuthEvent($mvcAuthEvent);
        $events->attach(
            MvcAuthEvent::EVENT_AUTHENTICATION_POST,
            $serviceManager->get('user.auth.activeuser.listener')
        );
        // add header if get http status 401
        $events->attach(
            \Zend\Mvc\MvcEvent::EVENT_FINISH,
            $serviceManager->get('user.auth.unauthorized.listener'),
            -100
        );
        // notification email for signup
        $signupNotificationEmailListener = $serviceManager->get('user.notification.email.signup.listener');
        $signupNotificationEmailListener->attach($signupService->getEventManager());
        // notification email for activation
        $activationNotificationEmailListener = $serviceManager->get('user.notification.email.activation.listener');
        $activationNotificationEmailListener->attach($userActivationService->getEventManager());
        // notification email for reset password
        $resetPasswordNotificationEmailListener = $serviceManager->get(
            'user.notification.email.resetpassword.listener'
        );
        $resetPasswordNotificationEmailListener->attach($resetPasswordService->getEventManager());
    }

    public function getConfig()
    {
        $config = [];
        $configFiles = [
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/doctrine.config.php',  // configuration for doctrine
        ];

        // merge all module config options
        foreach ($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile, true);
        }

        return $config;
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }

    public function getConsoleUsage(Console $console)
    {
        return [
            // available command
            'v1 user send-welcome-email <emailAddress> <activationCode>' => 'Send Welcome Email to New User',
            'v1 user send-activation-email <emailAddress>' => 'Send Notification Account Activated to New User',
            'v1 user send-resetpassword-email <emailAddress> <resetPaswordKey>' => 'Send Reset Password Link to Email',

            // describe expected parameters
            [ 'emailAddress',   'Email Address of New User'],
            [ 'activationCode', 'Activation Code for New user'],
            [ 'resetPaswordKey', 'Reset Password Key']
        ];
    }
}
