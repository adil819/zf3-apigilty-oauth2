<?php
namespace User\V1\Rest\Profile;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use ZF\ApiProblem\ApiProblemResponse;
use User\Mapper\UserProfile as UserProfileMapper;
use User\V1\Service\Profile as UserProfileService;
use Zend\Paginator\Paginator as ZendPaginator;

class ProfileResource extends AbstractResourceListener
{
    protected $userProfileMapper;

    protected $userProfileService;

    public function __construct(UserProfileMapper $userProfileMapper, UserProfileService $userProfileService)
    {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserProfileService($userProfileService);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        // BARU DIBUAT
        $userProfile = $this->getUserProfileMapper()->fetchOneBy(['uuid' => $id]);

        return $userProfile;
        //return new ApiProblem(405, 'The POST method has not been defined');
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
        $userProfile = $this->getUserProfileMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile not found"));
        }

        return $userProfile;
    }

    /** 
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */

    //  // INI FUNGSI fetchAll yang disimple
    public function fetchAll($params = [])
    {
        $queryParams = [];
        $qb = $this->getUserProfileMapper()->fetchAll($queryParams);  
        //return $qb;  // INI RETURN TANPA PAGINATION

        // FUNGSI createPaginatorAdapter DARI BAWAAN BANG HAKIMx
        // $paginatorAdapter = $this->getUserProfileMapper()->createPaginatorAdapter($qb);
        $paginatorAdapter = $this->getUserProfileMapper()->buildListPaginatorAdapter($queryParams, $order, $asc);
        return new ZendPaginator($paginatorAdapter);

        // $paginatorAdapter = $this->getUserProfileMapper()->buildListPaginatorAdapter($queryParams, $order, $asc);
        // return new ZendPaginator($paginatorAdapter);  
    }

    // INI FUNGSI fetchAll full dari Bang Hakim
    // public function fetchAll($params = [])
    // {
    //     $urlParams = $params->toArray();
    //     // $userProfile = $this->fetchUserProfile();
    //     // if(is_null($userProfile)) {
    //     //     return new ApiProblemResponse(new ApiProblem(401, 'You\'re not authorized'));
    //     // }

    //     // $queryParams = [];
    //     // if (! is_null($userProfile->getAccount())) {
    //     //     $queryParams  = [
    //     //         'account' => $userProfile->getAccount()->getUuid(),
    //     //     ];
    //     // }

    //     $order = null;
    //     $asc   = false;
    //     if (isset($urlParams['order'])) {
    //         $order = $urlParams['order'];
    //         unset($urlParams['order']);
    //     }

    //     if (isset($urlParams['asc'])) {
    //         $asc = $urlParams['asc'];
    //         unset($urlParams['asc']);
    //     }

    //     // $queryParams = array_merge($queryParams, $urlParams);
    //     $queryParams = [];
    //     $qb = $this->getUserProfileMapper()->fetchAll($queryParams, $order, $asc);  
    //     return $qb; // INI RETURN TANPA PAGINATION

    //     //$paginatorAdapter = $this->getUserProfileMapper()->createPaginatorAdapter($qb);
    //     //return new ZendPaginator($paginatorAdapter);

    //     // $paginatorAdapter = $this->getUserProfileMapper()->buildListPaginatorAdapter($queryParams, $order, $asc);
    //     // return $paginatorAdapter;
    // }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resource');
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
        $userProfile = $this->getUserProfileMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile not found"));
        }

        $inputFilter = $this->getInputFilter();
        $this->getUserProfileService()->update($userProfile, $inputFilter);
        return $userProfile;
    }

    /**
     * @return the $userProfileMapper
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * @param UserProfileMapper $userProfileMapper
     */
    public function setUserProfileMapper(UserProfileMapper $userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    /**
     * @return the $userProfileService
     */
    public function getUserProfileService()
    {
        return $this->userProfileService;
    }

    /**
     * @param UserProfileService $userProfileService
     */
    public function setUserProfileService(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }
}
