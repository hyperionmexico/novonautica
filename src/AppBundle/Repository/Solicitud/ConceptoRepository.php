<?php

namespace AppBundle\Repository\Solicitud;

/**
 * ConceptoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConceptoRepository extends \Doctrine\ORM\EntityRepository
{
    function getConceptos($id)
    {
        $q = $this->createQueryBuilder('cs');
        return $q->select('cs','solicitud','marinaHumedaServicio','combustibleCatalogo','astilleroProducto','tiendaProducto')
            ->leftJoin('cs.solicitud','solicitud')
            ->leftJoin('cs.marinaServicio','marinaHumedaServicio')
            ->leftJoin('cs.combustibleCatalogo','combustibleCatalogo')
            ->leftJoin('cs.astilleroProducto','astilleroProducto')
            ->leftJoin('cs.tiendaProducto','tiendaProducto')
            ->where($q->expr()->eq('cs.solicitud',':idsolicitud'))
            ->setParameter('idsolicitud',$id)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}
