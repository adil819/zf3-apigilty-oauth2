<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * room Mapper
 */
class RoomUsers extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\RoomUsers');
    }

    public function fetchAll(array $params = [], $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('r');
        $cacheKey = '';

        // di Apigility => Collection Query String Whitelist => tambah kolom nya
        if (isset($params['uuid'])) {
            // $params['name'] = (int)$params['name'];
            $qb->andWhere('r.uuid = :uuid')
               ->setParameter('uuid', $params['uuid']);
            $cacheKey .= '_' . $params['uuid'];
        }

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600);
        // $result = $query->getResult();
        // return $result;
        return $query;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        // return new ApiProblem(405, 'The GET method has not been defined for individual resources');

        // $roomUsers = $this->getRoomUsersMapper()->fetchOneBy(['uuid' => $id]);
        // return $roomUsers;
    }
}
