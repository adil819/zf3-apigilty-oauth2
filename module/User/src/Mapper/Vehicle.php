<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Vehicle Mapper
 */
class Vehicle extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\Vehicle');
    }

    // INI FUNGSI fetchAll dari Bang Hakim untuk di mapper
    
    // OVERRIDING fetchAll class parents, yaitu AbstractMapper
    public function fetchAll(array $params = [], $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('r');
        $cacheKey = '';

        // di Apigility => Collection Query String Whitelist => tambah kolom nya        
        
        if (isset($params['brand'])) {
            // $params['brand'] = (int)$params['brand'];
            $qb->andWhere('r.brand = :brand')
               ->setParameter('brand', $params['brand']);
            $cacheKey .= '_' . $params['brand'];
        }
        if (isset($params['wheel'])) {
            // $params['wheel'] = (int)$params['wheel'];
            $qb->andWhere('r.wheel = :wheel')
               ->setParameter('wheel', $params['wheel']);
            $cacheKey .= '_' . $params['wheel'];
        }
        if (isset($params['productionYear'])) {
            // $params['wheel'] = (int)$params['wheel'];
            $qb->andWhere('r.productionYear > :productionYear')
               ->setParameter('productionYear', $params['productionYear']);
            $cacheKey .= '_' . $params['productionYear'];
        }
        

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600);
        // $result = $query->getResult();
        // return $result;
        return $query;
    }

    // public function delete(array $param)

}
