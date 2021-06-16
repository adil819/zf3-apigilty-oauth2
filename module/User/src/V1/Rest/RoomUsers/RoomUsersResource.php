<?php
namespace User\V1\Rest\RoomUsers;

use Psr\Log\LoggerAwareTrait;
use RuntimeException;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;
use Zend\Paginator\Paginator as ZendPaginator;


class RoomUsersResource extends AbstractResourceListener
{
    use LoggerAwareTrait;

    protected $roomUsersMapper;
    protected $roomUsersService;

    public function __construct(
        \User\Mapper\RoomUsers $roomUsersMapper
    ) {
        $this->setRoomUsersMapper($roomUsersMapper);
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
        
        // var_dump(get_class($this->getRoomUsersMapper()));
        try{
            $inputFilter = $this->getInputFilter();

            // var_dump($inputFilter); exit();
            $roomUsers = $this->getRoomUsersService()->save($inputFilter);
            // return new ApiProblem(405, 'The POST method has not been defined');
        } catch (RuntimeException $e){
            return new ApiProblem(500, $e->getMessage());
        }
        return $roomUsers;
    }

    /**
     *  Patch (partian in-place update) a resource
     * 
     * @param mixed $id
     * @param mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data){
        // var_dump("Yeyy coba dulu");
        $roomUsers = $this->getRoomUsersMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($roomUsers)){
            return new ApiProblem(404, "Room Users Not Found");
        }
        // var_dump($roomUsers);
        $inputFilter = $this->getInputFilter()->getValues();

        try{
            // $roomUsers = $this->getRoomUsersService()->update($roomUsers, $this->getInputFilter());
            $roomUsers = $this->getRoomUsersService()->update($roomUsers, $this->getInputFilter());
            return $roomUsers;
        } catch (RuntimeException $e){
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
        $roomUsers = $this->getRoomUsersMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($roomUsers)){
            return new ApiProblem(404, "Room Users Not Found KENAPAAA");
        }
        $inputFilter = $this->getInputFilter();

        return $this->getRoomUsersService()->delete($roomUsers);
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
        $qb = $this->getRoomUsersMapper()->fetchAll($queryParams);
        $paginatorAdapter = $this->getRoomUsersMapper()->buildListPaginatorAdapter($queryParams, $order, $asc);
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
     * Get the value of roomUsersMapper
     */ 
    public function getRoomUsersMapper()
    {
        return $this->roomUsersMapper;
    }

    /**
     * Set the value of roomUsersMapper
     *
     * @return  self
     */ 
    public function setRoomUsersMapper($roomUsersMapper)
    {
        $this->roomUsersMapper = $roomUsersMapper;

        return $this;
    }

    /**
     * Get the value of roomService
     */ 
    public function getRoomUsersService()
    {
        return $this->roomUsersService;
    }

    /**
     * Set the value of roomUsersService
     *
     * @return  self
     */ 
    public function setRoomUsersService($roomUsersService)
    {
        $this->roomUsersService = $roomUsersService;

        return $this;
    }
}
