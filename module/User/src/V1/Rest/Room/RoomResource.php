<?php
namespace User\V1\Rest\Room;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use ZF\ApiProblem\ApiProblemResponse;
use User\Mapper\Room as RoomMapper;
use Zend\Paginator\Paginator as ZendPaginator;

class RoomResource extends AbstractResourceListener
{
    protected $roomMapper;

    protected $roomService;

    public function __construct(RoomMapper $roomMapper)
    {
        $this->setRoomMapper($roomMapper);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
        $room = $this->getRoomMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($room)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile not found"));
        }

        return $room;
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
        // var_dump($urlParams);exit;
        $queryParams = [];
        $queryParams = array_merge($urlParams, $queryParams);
        $qb = $this->getRoomMapper()->fetchAll($queryParams);  
        // return $qb;  // INI RETURN TANPA PAGINATION

        // FUNGSI createPaginatorAdapter DARI BAWAAN BANG HAKIM
        // $paginatorAdapter = $this->getUserProfileMapper()->createPaginatorAdapter($qb);
         $paginatorAdapter = $this->getRoomMapper()->buildListPaginatorAdapter($queryParams, $order, $asc);
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
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
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
     * @return the $userProfileMapper
     */
    public function getRoomMapper()
    {
        return $this->roomMapper;
    }

    /**
     * @param RoomMapper $userProfileMapper
     */
    public function setRoomMapper(RoomMapper $roomMapper)
    {
        $this->roomMapper = $roomMapper;
    }
}
