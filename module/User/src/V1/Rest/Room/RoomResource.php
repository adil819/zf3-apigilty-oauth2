<?php
namespace User\V1\Rest\Room;

use Psr\Log\LoggerAwareTrait;
use RuntimeException;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;
use User\Mapper\Room as RoomMapper;
use Zend\Paginator\Paginator as ZendPaginator;

class RoomResource extends AbstractResourceListener
{
    use LoggerAwareTrait;

    protected $roomMapper;
    protected $roomService;

    public function __construct(
        \User\Mapper\Room $roomMapper
    ) {
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
        // var_dump("tes aja dlu, hbis ni diapus");exit();
        try {
            $inputFilter = $this->getInputFilter();
            // $roomUuid = $inputFilter->getValue('uuid');
            // $room = $this->getRoomMapper()->fetchOneBy(['uuid' => $roomUuid]);
            // if(! is_null($room)){
            //     return new ApiProblem(422, "Room with uuid ".$roomUuid."already exist!");
            // }

            $room = $this->getRoomService()->save($inputFilter);
        } catch (RuntimeException $e) {
            return new ApiProblem(500, $e->getMessage());
        }
        return $room;
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
        $room  = $this->getRoomMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($room)) {
            return new ApiProblem(404, "Room Not Found");
        }
        $inputFilter = $this->getInputFilter()->getValues();

        // var_dump($inputFilter);
        try {
            $room = $this->getRoomService()->update($room, $this->getInputFilter());
            return $room;
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
        $room = $this->getRoomMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($room)) {
            return new ApiProblem(404, "Room Not Found");
        }
        $inputFilter = $this->getInputFilter();

        return $this->getRoomService()->delete($room);
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
            return new ApiProblemResponse(new ApiProblem(404, "Room not found"));
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
     * @return the $roomMapper
     */
    public function getRoomMapper()
    {
        return $this->roomMapper;
    }

    /**
     * @param RoomMapper $roomMapper
     */
    public function setRoomMapper(RoomMapper $roomMapper)
    {
        $this->roomMapper = $roomMapper;
    }

    /**
     * Get the value of roomService
     */
    public function getRoomService()
    {
        return $this->roomService;
    }

    /**
     * Set the value of roomService
     */
    public function setRoomService($roomService): self
    {
        $this->roomService = $roomService;

        return $this;
    }
}
