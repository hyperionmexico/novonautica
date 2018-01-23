<?php

namespace AppBundle\Repository\Cliente;

/**
 * RazonSocialRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RazonSocialRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLikeRfc($rfc)
    {

        return $this->createQueryBuilder('rfc')
            ->select('rfc', 'cl')
            ->leftJoin('rfc.cliente', 'cl')
            ->where('LOWER(rfc.rfc) LIKE :value')
            ->orWhere('LOWER(cl.nombre) LIKE :value')
            ->setParameter(':value', strtolower("%{$rfc}%"))
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
