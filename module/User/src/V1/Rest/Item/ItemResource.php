<?php
namespace User\V1\Rest\Item;

use Psr\Log\LoggerAwareTrait;
use RuntimeException;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use User\Mapper\Item as ItemMapper;
use Zend\Paginator\Paginator as zendPaginator;
use ZF\ApiProblem\ApiProblemResponse;

class ItemResource extends AbstractResourceListener
{
    protected $itemMapper;
    protected $itemService;

    public function __construct(
        \User\Mapper\Item $itemMapper
    ) {
        $this->setItemMapper($itemMapper);
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
        try{
            $inputFilter = $this->getInputFilter();
            $item = $this->getItemService()->save($inputFilter);
        } catch (RuntimeException $e){
            return new ApiProblem(500, $e->getMessage());
        }
        return $item;
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
        $item = $this->getItemMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($item)){
            return new ApiProblem(404, "Item not Found");
        }
        $inputFilter = $this->getInputFilter();

        return $this->getItemService()->delete($item);
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
        $item = $this->getItemMapper()->fetchOneBy(['uuid' => $id]);
        // return new ApiProblem(405, 'The GET method has not been defined for individual resources');
        if (is_null($item)){
            return new ApiProblemResponse(new ApiProblem(404, "Item not found"));
        }

        return $item;
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
        $qb = $this->getItemMapper()->fetchAll($queryParams);
        $paginatorAdapter = $this->getItemMapper()->buildListPaginatorAdapter($queryParams, $order, $asc);
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
       $item = $this->getItemMapper()->fetchOneBy(['uuid' => $id]) ;
       if (is_null($item)) {
           return new ApiProblem(404, "Item Not Found");
       }
       $inputFilter = $this->getInputFilter()->getValues();

       try {
           $item = $this->getItemService()->update($item, $this->getInputFilter());
           return $item;
       } catch (RuntimeException $e){
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

    public function getItemMapper()
    {
        return $this->itemMapper;
    }

    public function setItemMapper(ItemMapper $itemMapper)
    {
        $this->itemMapper = $itemMapper;
    }

    public function getItemService()
    {
        return $this->itemService;
    }

    public function setItemService($itemService): self
    {
        $this->itemService = $itemService;

        return $this;
    }
}
