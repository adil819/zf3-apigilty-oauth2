<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserProfile Mapper
 */
class Room extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\Room');
    }

    // INI FUNGSI fetchAll dari Bang Hakim untuk di mapper
    
    public function fetchAll(array $params = [], $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('r');
        $cacheKey = '';

        // if (isset($params['capacity'])) {
        //     $params['capacity'] = (int)$params['capacity'];
        //     $qb->andWhere('r.capacity > :capacity')
        //        ->setParameter('capacity', $params['capacity']);
        //     $cacheKey .= '_' . $params['capacity'];
        // }

        // di Apigility => Collection Query String Whitelist => tambah kolom nya
        if (isset($params['name'])) {
            // $params['name'] = (int)$params['name'];
            $qb->andWhere('r.name = :name')
               ->setParameter('name', $params['name']);
            $cacheKey .= '_' . $params['name'];
        }

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600);
        // $result = $query->getResult();
        // return $result;
        return $query;
    }

}
