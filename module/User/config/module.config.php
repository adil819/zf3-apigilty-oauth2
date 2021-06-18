<?php
return [
    'controllers' => [
        'factories' => [
            'User\\V1\\Rpc\\Signup\\Controller' => \User\V1\Rpc\Signup\SignupControllerFactory::class,
            'User\\V1\\Rpc\\Me\\Controller' => \User\V1\Rpc\Me\MeControllerFactory::class,
            'User\\V1\\Rpc\\UserActivation\\Controller' => \User\V1\Rpc\UserActivation\UserActivationControllerFactory::class,
            \User\V1\Console\Controller\EmailController::class => \User\V1\Console\Controller\EmailControllerFactory::class,
            'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => \User\V1\Rpc\ResetPasswordConfirmEmail\ResetPasswordConfirmEmailControllerFactory::class,
            'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => \User\V1\Rpc\ResetPasswordNewPassword\ResetPasswordNewPasswordControllerFactory::class,
            'User\\V1\\Rpc\\UserRoomStats\\Controller' => \User\V1\Rpc\UserRoomStats\UserRoomStatsControllerFactory::class,
            'User\\V1\\Rpc\\UserVehicleStats\\Controller' => \User\V1\Rpc\UserVehicleStats\UserVehicleStatsControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'user.resetpassword' => \User\V1\Service\ResetPasswordFactory::class,
            'user.activation' => \User\V1\Service\UserActivationFactory::class,
            'user.signup' => \User\V1\Service\SignupFactory::class,
            'user.profile' => \User\V1\Service\ProfileFactory::class,
            'user.activation.listener' => \User\V1\Service\Listener\UserActivationEventListenerFactory::class,
            'user.resetpassword.listener' => \User\V1\Service\Listener\ResetPasswordEventListenerFactory::class,
            'user.signup.listener' => \User\V1\Service\Listener\SignupEventListenerFactory::class,
            'user.profile.listener' => \User\V1\Service\Listener\ProfileEventListenerFactory::class,
            'user.notification.email.signup.listener' => \User\V1\Notification\Email\Listener\SignupEventListenerFactory::class,
            'user.notification.email.activation.listener' => \User\V1\Notification\Email\Listener\ActivationEventListenerFactory::class,
            'user.notification.email.resetpassword.listener' => \User\V1\Notification\Email\Listener\ResetPasswordEventListenerFactory::class,
            'user.notification.email.service.resetpassword' => \User\V1\Notification\Email\Service\ResetPasswordFactory::class,
            'user.notification.email.service.welcome' => \User\V1\Notification\Email\Service\WelcomeFactory::class,
            'user.notification.email.service.activation' => \User\V1\Notification\Email\Service\ActivationFactory::class,
            'user.auth.pdo.adapter' => \User\OAuth2\Factory\PdoAdapterFactory::class,
            'user.auth.activeuser.listener' => \User\Service\Listener\AuthActiveUserListenerFactory::class,
            'user.hydrator.photo.strategy' => \User\V1\Hydrator\Strategy\PhotoStrategyFactory::class,
            'user.auth.unauthorized.listener' => \User\Service\Listener\UnauthorizedUserListenerFactory::class,
            \User\V1\Rest\Profile\ProfileResource::class => \User\V1\Rest\Profile\ProfileResourceFactory::class,
            \User\V1\Rest\Room\RoomResource::class => \User\V1\Rest\Room\RoomResourceFactory::class,
            \User\V1\Service\Room::class => \User\V1\Service\RoomFactory::class,
            \User\V1\Service\Listener\RoomEventListener::class => \User\V1\Service\Listener\RoomEventListenerFactory::class,
            \User\V1\Rest\Vehicle\VehicleResource::class => \User\V1\Rest\Vehicle\VehicleResourceFactory::class,
            \User\V1\Service\Vehicle::class => \User\V1\Service\VehicleFactory::class,
            \User\V1\Service\Listener\VehicleEventListener::class => \User\V1\Service\Listener\VehicleEventListenerFactory::class,
            \User\V1\Rest\RoomUsers\RoomUsersResource::class => \User\V1\Rest\RoomUsers\RoomUsersResourceFactory::class,
            \User\V1\Service\RoomUsers::class => \User\V1\Service\RoomUsersFactory::class,
            \User\V1\Service\Listener\RoomUsersEventListener::class => \User\V1\Service\Listener\RoomUsersEventListenerFactory::class,
            \User\V1\Rest\VehicleUsers\VehicleUsersResource::class => \User\V1\Rest\VehicleUsers\VehicleUsersResourceFactory::class,
            \User\V1\Service\VehicleUsers::class => \User\V1\Service\VehicleUsersFactory::class,
            \User\V1\Service\Listener\VehicleUsersEventListener::class => \User\V1\Service\Listener\VehicleUsersEventListenerFactory::class,
        ],
        'abstract_factories' => [
            0 => \User\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'User\\Hydrator\\UserProfile' => \User\V1\Hydrator\UserProfileHydratorFactory::class,
            'User\\Hydrator\\Room' => \User\V1\Hydrator\RoomHydratorFactory::class,
            'User\\Hydrator\\RoomUsers' => \User\V1\Hydrator\RoomUsersHydratorFactory::class,
            'User\\Hydrator\\Vehicle' => \User\V1\Hydrator\VehicleHydratorFactory::class,
            'User\\Hydrator\\VehicleUsers' => \User\V1\Hydrator\VehicleUsersHydratorFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            0 => __DIR__ . '/../view',
        ],
    ],
    'router' => [
        'routes' => [
            'user.rpc.signup' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/signup',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\Signup\\Controller',
                        'action' => 'signup',
                    ],
                ],
            ],
            'user.rest.profile' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/profile[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\Profile\\Controller',
                    ],
                ],
            ],
            'user.rpc.me' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/me',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\Me\\Controller',
                        'action' => 'me',
                    ],
                ],
            ],
            'user.rpc.user-activation' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/user/activation',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\UserActivation\\Controller',
                        'action' => 'activation',
                    ],
                ],
            ],
            'user.rpc.reset-password-confirm-email' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/resetpassword/email',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller',
                        'action' => 'resetPasswordConfirmEmail',
                    ],
                ],
            ],
            'user.rpc.reset-password-new-password' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/resetpassword/newpassword',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller',
                        'action' => 'resetPasswordNewPassword',
                    ],
                ],
            ],
            'user.rest.room' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/room[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\Room\\Controller',
                    ],
                ],
            ],
            'user.rest.vehicle' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/vehicle[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\Vehicle\\Controller',
                    ],
                ],
            ],
            'user.rest.room-users' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/room-users[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\RoomUsers\\Controller',
                    ],
                ],
            ],
            'user.rest.vehicle-users' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/vehicle-users[/:uuid]',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rest\\VehicleUsers\\Controller',
                    ],
                ],
            ],
            'user.rpc.user-room-stats' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/user-room-stats',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\UserRoomStats\\Controller',
                        'action' => 'userRoomStats',
                    ],
                ],
            ],
            'user.rpc.user-vehicle-stats' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/user-vehicle-stats',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\UserVehicleStats\\Controller',
                        'action' => 'userVehicleStats',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'user.rpc.signup',
            1 => 'user.rest.profile',
            2 => 'user.rpc.me',
            3 => 'user.rpc.me',
            4 => 'user.rpc.user-activation',
            5 => 'user.rpc.reset-password-confirm-email',
            6 => 'user.rpc.reset-password-new-password',
            7 => 'user.rest.room',
            8 => 'user.rest.vehicle',
            9 => 'user.rest.room-users',
            10 => 'user.rest.vehicle-users',
            11 => 'user.rpc.user-room-stats',
            12 => 'user.rpc.user-room-stats',
            13 => 'user.rpc.user-vehicle-stats',
        ],
    ],
    'zf-rpc' => [
        'User\\V1\\Rpc\\Signup\\Controller' => [
            'service_name' => 'Signup',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.signup',
        ],
        'User\\V1\\Rpc\\Me\\Controller' => [
            'service_name' => 'Me',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user.rpc.me',
        ],
        'User\\V1\\Rpc\\UserActivation\\Controller' => [
            'service_name' => 'UserActivation',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.user-activation',
        ],
        'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => [
            'service_name' => 'ResetPasswordConfirmEmail',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.reset-password-confirm-email',
        ],
        'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => [
            'service_name' => 'ResetPasswordNewPassword',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user.rpc.reset-password-new-password',
        ],
        '' => [
            'service_name' => 'UserRoomStats',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user.rpc.user-room-stats',
        ],
        'User\\V1\\Rpc\\UserRoomStats\\Controller' => [
            'service_name' => 'UserRoomStats',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user.rpc.user-room-stats',
        ],
        'User\\V1\\Rpc\\UserVehicleStats\\Controller' => [
            'service_name' => 'UserVehicleStats',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user.rpc.user-vehicle-stats',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'User\\V1\\Rpc\\Signup\\Controller' => 'Json',
            'User\\V1\\Rest\\Profile\\Controller' => 'HalJson',
            'User\\V1\\Rpc\\Me\\Controller' => 'Json',
            'User\\V1\\Rpc\\UserActivation\\Controller' => 'Json',
            'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => 'Json',
            'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => 'Json',
            'User\\V1\\Rest\\Room\\Controller' => 'HalJson',
            'User\\V1\\Rest\\Vehicle\\Controller' => 'HalJson',
            'User\\V1\\Rest\\RoomUsers\\Controller' => 'HalJson',
            'User\\V1\\Rest\\VehicleUsers\\Controller' => 'HalJson',
            '' => 'Json',
            'User\\V1\\Rpc\\UserRoomStats\\Controller' => 'Json',
            'User\\V1\\Rpc\\UserVehicleStats\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'User\\V1\\Rpc\\Signup\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rest\\Profile\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
                2 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\Me\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\UserActivation\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rest\\Room\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'User\\V1\\Rest\\Vehicle\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'User\\V1\\Rest\\RoomUsers\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'User\\V1\\Rest\\VehicleUsers\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            '' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\UserRoomStats\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'User\\V1\\Rpc\\UserVehicleStats\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
            'User\\V1\\Rpc\\Signup\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1.json',
            ],
            'User\\V1\\Rest\\Profile\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
                2 => 'application/hal+json',
                3 => 'multipart/form-data',
            ],
            'User\\V1\\Rpc\\Me\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\UserActivation\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => [
                0 => 'application/json',
                1 => 'application/vnd.aqilix.bootstrap.v1+json',
            ],
            'User\\V1\\Rest\\Room\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\Vehicle\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\RoomUsers\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rest\\VehicleUsers\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            '' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rpc\\UserRoomStats\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
            'User\\V1\\Rpc\\UserVehicleStats\\Controller' => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-content-validation' => [
        'User\\V1\\Rpc\\Signup\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\Signup\\Validator',
        ],
        'User\\V1\\Rest\\Profile\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\Profile\\Validator',
        ],
        'User\\V1\\Rpc\\UserActivation\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\UserActivation\\Validator',
        ],
        'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Validator',
        ],
        'User\\V1\\Rpc\\ResetPasswordNewPassword\\Controller' => [
            'input_filter' => 'User\\V1\\Rpc\\ResetPasswordNewPassword\\Validator',
        ],
        'User\\V1\\Rest\\Room\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\Room\\Validator',
        ],
        'User\\V1\\Rest\\Vehicle\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\Vehicle\\Validator',
        ],
        'User\\V1\\Rest\\RoomUsers\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\RoomUsers\\Validator',
        ],
        'User\\V1\\Rest\\VehicleUsers\\Controller' => [
            'input_filter' => 'User\\V1\\Rest\\VehicleUsers\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'User\\V1\\Rpc\\Signup\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [
                            'message' => 'Email Address Required',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'email',
                'description' => 'Email Address',
                'field_type' => 'email',
                'error_message' => 'Email Address Required',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [
                            'message' => 'Password should contain alpha numeric string',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'password',
                'description' => 'User Password',
                'field_type' => 'password',
                'error_message' => 'Password length at least 6 character with alphanumeric format',
            ],
        ],
        'User\\V1\\Rest\\Profile\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'firstName',
                'description' => 'First Name',
                'field_type' => 'String',
                'error_message' => 'First Name Required',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'lastName',
                'description' => 'Last Name',
                'field_type' => 'String',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Date::class,
                        'options' => [
                            'format' => 'Y-m-d',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'dateOfBirth',
                'description' => 'Date Of Birth',
                'field_type' => 'String',
                'error_message' => 'Date not valid',
            ],
            3 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripNewlines::class,
                        'options' => [],
                    ],
                ],
                'name' => 'address',
                'description' => 'Address',
                'error_message' => 'Address Required',
            ],
            4 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripNewlines::class,
                        'options' => [],
                    ],
                ],
                'name' => 'city',
                'description' => 'City',
                'error_message' => 'City Required',
            ],
            5 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripNewlines::class,
                        'options' => [],
                    ],
                ],
                'name' => 'province',
                'description' => 'Province',
                'error_message' => 'Province Required',
            ],
            6 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\PostCode::class,
                        'options' => [
                            'message' => 'Postal code should be 5 digit numeric characters',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\Digits::class,
                        'options' => [],
                    ],
                ],
                'name' => 'postalCode',
                'description' => 'Postal Code',
                'error_message' => 'Postal Code Required',
            ],
            7 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripNewlines::class,
                        'options' => [],
                    ],
                ],
                'name' => 'country',
                'description' => 'Country',
            ],
            8 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'extension' => 'png, jpg, jpeg',
                            'message' => 'File extension not match',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'mimeType' => 'image/png, image/jpeg',
                            'message' => 'File type extension not match',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'use_upload_extension' => true,
                            'randomize' => true,
                            'target' => 'data/photo',
                        ],
                    ],
                ],
                'name' => 'photo',
                'description' => 'Photo',
                'field_type' => 'File',
                'type' => \Zend\InputFilter\FileInput::class,
                'error_message' => 'Photo is not valid',
            ],
        ],
        'User\\V1\\Rpc\\UserActivation\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'activationUuid',
                'description' => 'Activation UUID',
                'error_message' => 'Activation UUID required',
            ],
        ],
        'User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [
                            'message' => 'Email Address Required',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'emailAddress',
                'description' => 'Email Address',
                'field_type' => 'EmailAddress',
                'error_message' => 'Email Address Required',
            ],
        ],
        'User\\V1\\Rpc\\ResetPasswordNewPassword\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'resetPasswordKey',
                'description' => 'Reset Password Key',
                'error_message' => 'Reset Password Key Not Valid',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'newPassword',
                'description' => 'New Password',
                'error_message' => 'New Password Not Valid',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '8',
                        ],
                    ],
                    2 => [
                        'name' => \Zend\Validator\Identical::class,
                        'options' => [
                            'token' => 'newPassword',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'confirmNewPassword',
                'description' => 'Confirm New Password',
                'error_message' => 'Confirm New Password not valid',
            ],
        ],
        'User\\V1\\Rest\\Room\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'capacity',
                'description' => 'Capacity',
                'field_type' => 'Integer',
                'error_message' => 'Capacity Required',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                ],
                'name' => 'name',
                'description' => 'Name',
                'field_type' => 'String',
                'error_message' => 'Name Required',
            ],
        ],
        'User\\V1\\Rest\\Vehicle\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [
                            'charlist' => '!,@,#,$,%,^,&,*,(,),-,_,+,=,|,],},{,[,:,;,:',
                        ],
                    ],
                ],
                'name' => 'brand',
                'description' => 'Brand',
                'field_type' => 'String',
                'error_message' => 'Brand Required',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'wheel',
                'description' => 'Wheel',
                'field_type' => 'Integer',
                'error_message' => 'Wheel Required',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'productionYear',
                'description' => 'Production Year',
                'field_type' => 'Integer',
                'error_message' => 'Production Year Required',
            ],
        ],
        'User\\V1\\Rest\\RoomUsers\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'reservationTime',
                'description' => 'Reservation Time',
                'field_type' => 'String',
                'error_message' => 'Time not valid',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'room',
                'description' => 'Room',
                'field_type' => 'String',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'userProfile',
                'field_type' => 'String',
            ],
        ],
        'User\\V1\\Rest\\VehicleUsers\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'vehicle',
                'field_type' => 'String',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'userProfile',
                'field_type' => 'String',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'bookingDay',
            ],
        ],
    ],
    'zf-rest' => [
        'User\\V1\\Rest\\Profile\\Controller' => [
            'listener' => \User\V1\Rest\Profile\ProfileResource::class,
            'route_name' => 'user.rest.profile',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'profile',
            'entity_http_methods' => [
                0 => 'GET',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => '25',
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\UserProfile::class,
            'collection_class' => \User\V1\Rest\Profile\ProfileCollection::class,
            'service_name' => 'Profile',
        ],
        'User\\V1\\Rest\\Room\\Controller' => [
            'listener' => \User\V1\Rest\Room\RoomResource::class,
            'route_name' => 'user.rest.room',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'room',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'asc',
                2 => 'name',
                3 => 'uuid',
                4 => 'capacity',
            ],
            'page_size' => '25',
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\Room::class,
            'collection_class' => \User\V1\Rest\Room\RoomCollection::class,
            'service_name' => 'Room',
        ],
        'User\\V1\\Rest\\Vehicle\\Controller' => [
            'listener' => \User\V1\Rest\Vehicle\VehicleResource::class,
            'route_name' => 'user.rest.vehicle',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'vehicle',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'order',
                1 => 'asc',
                2 => 'brand',
                3 => 'wheel',
                4 => 'productionYear',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\Vehicle::class,
            'collection_class' => \User\V1\Rest\Vehicle\VehicleCollection::class,
            'service_name' => 'Vehicle',
        ],
        'User\\V1\\Rest\\RoomUsers\\Controller' => [
            'listener' => \User\V1\Rest\RoomUsers\RoomUsersResource::class,
            'route_name' => 'user.rest.room-users',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'roomUsers',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'roomUuid',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\RoomUsers::class,
            'collection_class' => \User\V1\Rest\RoomUsers\RoomUsersCollection::class,
            'service_name' => 'RoomUsers',
        ],
        'User\\V1\\Rest\\VehicleUsers\\Controller' => [
            'listener' => \User\V1\Rest\VehicleUsers\VehicleUsersResource::class,
            'route_name' => 'user.rest.vehicle-users',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'vehicleUsers',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \User\Entity\VehicleUsers::class,
            'collection_class' => \User\V1\Rest\VehicleUsers\VehicleUsersCollection::class,
            'service_name' => 'VehicleUsers',
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \User\Entity\UserProfile::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.profile',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\UserProfile',
            ],
            \User\V1\Rest\Profile\ProfileCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.profile',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            'User\\V1\\Rest\\Room\\RoomEntity' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.room',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\Room\RoomCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.room',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            'User\\Entity\\Room\\' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.room',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\UserProfile',
            ],
            \User\Entity\Room::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.room',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\Room',
            ],
            'User\\Entity\\Room.php' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.room',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            'User\\Entity' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.room',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            'User\\Entity/' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.room',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            'User\\Entity\\' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.room',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            'User\\V1\\Rest\\Vehicle\\VehicleEntity' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.vehicle',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\Room',
            ],
            \User\V1\Rest\Vehicle\VehicleCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.vehicle',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \User\Entity\Vehicle::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.vehicle',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\Vehicle',
            ],
            'User\\V1\\Rest\\RoomUsers\\RoomUsersEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.room-users',
                'route_identifier_name' => 'room_users_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \User\V1\Rest\RoomUsers\RoomUsersCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.room-users',
                'route_identifier_name' => 'room_users_id',
                'is_collection' => true,
            ],
            \User\Entity\RoomUsers::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.room-users',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\RoomUsers',
            ],
            'User\\V1\\Rest\\VehicleUsers\\VehicleUsersEntity' => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.vehicle-users',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\VehicleUsers',
            ],
            \User\V1\Rest\VehicleUsers\VehicleUsersCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.vehicle-users',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \User\Entity\VehicleUsers::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'user.rest.vehicle-users',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'User\\Hydrator\\VehicleUsers',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'User\\V1\\Rest\\Profile\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rpc\\Me\\Controller' => [
                'actions' => [
                    'Me' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rest\\Room\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\Vehicle\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\RoomUsers\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rest\\VehicleUsers\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'User\\V1\\Rpc\\UserRoomStats\\Controller' => [
                'actions' => [
                    'UserRoomStats' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'User\\V1\\Rpc\\UserVehicleStats\\Controller' => [
                'actions' => [
                    'UserVehicleStats' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'v1-send-welcome-email' => [
                    'options' => [
                        'route' => 'v1 user send-welcome-email <emailAddress> <activationCode>',
                        'defaults' => [
                            'controller' => \User\V1\Console\Controller\EmailController::class,
                            'action' => 'sendWelcomeEmail',
                        ],
                    ],
                ],
                'v1-send-activation-email' => [
                    'options' => [
                        'route' => 'v1 user send-activation-email <emailAddress>',
                        'defaults' => [
                            'controller' => \User\V1\Console\Controller\EmailController::class,
                            'action' => 'sendActivationEmail',
                        ],
                    ],
                ],
                'v1-send-resetpassword-email' => [
                    'options' => [
                        'route' => 'v1 user send-resetpassword-email <emailAddress> <resetPasswordKey>',
                        'defaults' => [
                            'controller' => \User\V1\Console\Controller\EmailController::class,
                            'action' => 'sendResetPasswordEmail',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
