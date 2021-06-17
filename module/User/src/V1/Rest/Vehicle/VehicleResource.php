<?php
namespace User\V1\Rest\Vehicle;

use Psr\Log\LoggerAwareTrait;
use RuntimeException;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;
use User\Mapper\Vehicle as VehicleMapper;
use Zend\Paginator\Paginator as ZendPaginator;

class VehicleResource extends AbstractResourceListener
{
    use LoggerAwareTrait;

    protected $vehicleMapper;
    protected $vehicleService;

    public function __construct(
        \User\Mapper\Vehicle $vehicleMapper
    ) {
        $this->setVehicleMapper($vehicleMapper);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        // var_dump("tes aja dlu, hbis ni diapus");exit();
        try {
            $inputFilter = $this->getInputFilter();
            // $vehicleUuid = $inputFilter->getValue('uuid');
            // $vehicle = $this->getVehicleMapper()->fetchOneBy(['uuid' => $vehicleUuid]);
            // if(! is_null($vehicle)){
            //     return new ApiProblem(422, "Vehicle with uuid ".$vehicleUuid."already exist!");
            // }

            $vehicle = $this->getVehicleService()->save($inputFilter);
        } catch (RuntimeException $e) {
            return new ApiProblem(500, $e->getMessage());
        }
        return $vehicle;
    }


    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        // var_dump("YEYY BISA MASUK PATCH");exit();
        $vehicle  = $this->getVehicleMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($vehicle)) {
            return new ApiProblem(404, "Vehicle Not Found");
        }
        $inputFilter = $this->getInputFilter()->getValues();

        // var_dump($inputFilter);
        try {
            $vehicle = $this->getVehicleService()->update($vehicle, $this->getInputFilter());
            return $vehicle;
        } catch (RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        // return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
        $vehicle = $this->getVehicleMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($vehicle)) {
            return new ApiProblem(404, "Vehicle Not Found KENAPAAA");
        }
        $inputFilter = $this->getInputFilter();

        return $this->getVehicleService()->delete($vehicle);
    }

    // /**
    //  * Delete a collection, or members of a collection
    //  *
    //  * @param  mixed $data
    //  * @return ApiProblem|mixed
    //  */
    // public function deleteList($data)
    // {
    //     return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    // }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $vehicle = $this->getVehicleMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($vehicle)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile not found"));
        }

        return $vehicle;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $urlParams = $params->toArray();
        $queryParams = [];
        $queryParams = array_merge($urlParams, $queryParams);
        $qb = $this->getVehicleMapper()->fetchAll($queryParams);
        // return $qb;  // INI RETURN TANPA PAGINATION

        // FUNGSI createPaginatorAdapter DARI BAWAAN BANG HAKIM
        // $paginatorAdapter = $this->getUserProfileMapper()->createPaginatorAdapter($qb);
         $paginatorAdapter = $this->getVehicleMapper()->buildListPaginatorAdapter($queryParams, $order, $asc);
         return new ZendPaginator($paginatorAdapter);
    }


    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }

    /**
     * @return the $vehicleMapper
     */
    public function getVehicleMapper()
    {
        return $this->vehicleMapper;
    }

    /**
     * @param VehicleMapper $vehicleMapper
     */
    public function setVehicleMapper(VehicleMapper $vehicleMapper)
    {
        $this->vehicleMapper = $vehicleMapper;
    }

    /**
     * Get the value of vehicleService
     */
    public function getVehicleService()
    {
        return $this->vehicleService;
    }

    /**
     * Set the value of vehicleService
     */
    public function setVehicleService($vehicleService): self
    {
        $this->vehicleService = $vehicleService;

        return $this;
    }
}
