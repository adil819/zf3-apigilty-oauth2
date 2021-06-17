<?php
namespace User\V1\Rest\VehicleUsers;

use Psr\Log\LoggerAwareTrait;
use RuntimeException;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;
use Zend\Paginator\Paginator as ZendPaginator;

class VehicleUsersResource extends AbstractResourceListener
{
    use LoggerAwareTrait;

    protected $vehicleUsersMapper;
    protected $vehicleUsersService;

    public function __construct(
        \User\Mapper\VehicleUsers $vehicleUsersMapper
    ) {
        $this->setVehicleUsersMapper($vehicleUsersMapper);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        // return new ApiProblem(405, 'The POST method has not been defined');
        try {
            $inputFilter = $this->getInputFilter();
            // var_dump("Hahahaha");
            $vehicleUsers = $this->getVehicleUsersService()->save($inputFilter);
        } catch (RuntimeException $e) {
            return new ApiProblem(500, $e->getMessage());
        }
        return $vehicleUsers;
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
        $vehicleUsers = $this->getVehicleUsersMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($vehicleUsers)) {
            return new ApiProblem(404, "Vehicle Users Not Found, Yes.");
        }
        $inputFilter = $this->getInputFilter();

        return $this->getVehicleUsersService()->delete($vehicleUsers);
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        // return new ApiProblem(405, 'The GET method has not been defined for collections');
        $urlParams = $params->toArray();
        $queryParams = [];
        $queryParams = array_merge($urlParams, $queryParams);
        $qb = $this->getVehicleUsersMapper()->fetchAll($queryParams);
        $paginatorAdapter = $this->getVehicleUsersMapper()->buildListPaginatorAdapter($queryParams, $order, $asc);
        return new ZendPaginator($paginatorAdapter);
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
        // return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
        $vehicleUsers = $this->getVehicleUsersMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($vehicleUsers)) {
            return new ApiProblem(404, "Vehicle Users Not Found");
        }

        $inputFilter = $this->getInputFilter()->getValues();

        try {
            $vehicleUsers = $this->getVehicleUsersService()->update($vehicleUsers, $this->getInputFilter());
        } catch (RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
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
     * Get the value of vehicleUsersMapper
     */
    public function getVehicleUsersMapper()
    {
        return $this->vehicleUsersMapper;
    }

    /**
     * Set the value of vehicleUsersMapper
     *
     * @return  self
     */
    public function setVehicleUsersMapper($vehicleUsersMapper)
    {
        $this->vehicleUsersMapper = $vehicleUsersMapper;

        return $this;
    }


    /**
     * Get the value of vehicleUsersService
     */
    public function getVehicleUsersService()
    {
        return $this->vehicleUsersService;
    }

    /**
     * Set the value of vehicleUsersService
     *
     * @return  self
     */
    public function setVehicleUsersService($vehicleUsersService)
    {
        $this->vehicleUsersService = $vehicleUsersService;

        return $this;
    }
}
