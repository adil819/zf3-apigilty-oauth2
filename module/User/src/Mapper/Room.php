<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Room Mapper
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

    public function fetchAll(array $params = [], $order = null, $asc = true)
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

        if (isset($params['uuid'])) {
            // $params['name'] = (int)$params['name'];
            $qb->andWhere('r.uuid = :uuid')
               ->setParameter('uuid', $params['uuid']);
            $cacheKey .= '_' . $params['uuid'];
        }

        if (isset($params['capacity'])) {
            // $params['name'] = (int)$params['name'];
            $qb->andWhere('r.capacity >= :capacity')
               ->setParameter('capacity', $params['capacity']);
            $cacheKey .= '_' . $params['capacity'];
        }

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600);
        // $query->orderBy('r.name', 'ASC');

        // $result = $query->getResult();
        // return $result;
        return $query;
    }

    // public function delete(array $param)
}
