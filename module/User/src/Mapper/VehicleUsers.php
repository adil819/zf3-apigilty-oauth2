<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * room Mapper
 */
class VehicleUsers extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\VehicleUsers');
    }

    public function fetchAll(array $params = [], $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('r');
        $cacheKey = '';

        // di Apigility => Collection Query String Whitelist => tambah kolom nya
        // if (isset($params['name'])) {
        //     // $params['name'] = (int)$params['name'];
        //     $qb->andWhere('r.name = :name')
        //        ->setParameter('name', $params['name']);
        //     $cacheKey .= '_' . $params['name'];
        // }

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600);
        // $result = $query->getResult();
        // return $result;
        return $query;
    }
}
