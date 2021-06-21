<?php
namespace User\V1\Rpc\MakeReservation;

class MakeReservationControllerFactory
{
    public function __invoke($controllers)
    {
        // return new MakeReservationController(null, null);

        $makeReservationValidator = $controllers->get('InputFilterManager')->get('User\\V1\\Rpc\\MakeReservation\\Validator');
        // $makeReservationValidator = $controllers->get('InputFilterManager');
        $makeReservationService = $controllers->get('user.make-reservation');
        return new MakeReservationController($makeReservationService, $makeReservationValidator);
    }
}
