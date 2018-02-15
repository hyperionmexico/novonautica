<?php

namespace AppBundle\Repository;

/**
 * SlipRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SlipRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllByGroupFeet()
    {
        return $this->createQueryBuilder('s')
            ->select('s.pies', 'COUNT(s.id) AS amarres')
            ->groupBy('s.pies')
            ->getQuery()
            ->getResult();
    }
}
