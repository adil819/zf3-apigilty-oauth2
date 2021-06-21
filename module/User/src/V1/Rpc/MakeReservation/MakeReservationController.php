<?php
namespace User\V1\Rpc\MakeReservation;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\Hal\View\HalJsonModel;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use Zend\Json\Json;

class MakeReservationController extends AbstractActionController
{
    protected $makeReservationValidator;
    protected $makeReservationService;

    public function __construct($makeReservationService,$makeReservationValidator)    
    {
        $this->makeReservationValidator = $makeReservationValidator;
        $this->makeReservationService   = $makeReservationService;
    }

    public function makeReservationAction()
    {
        $this->makeReservationValidator->setData(Json::decode($this->getRequest()->getContent(), true));
        // var_dump($this->makeReservationValidator->getValues());exit();
        try{
            $this->makeReservationService->register($this->makeReservationValidator->getValues());
            return new HalJsonModel($this->makeReservationService->getMakeReservationEvent()->getMakeReservationData());
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
    }
}
