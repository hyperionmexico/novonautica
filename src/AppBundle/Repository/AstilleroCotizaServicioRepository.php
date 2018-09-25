<?php

namespace AppBundle\Repository;

/**
 * AstilleroCotizaServicioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AstilleroCotizaServicioRepository extends \Doctrine\ORM\EntityRepository
{
    public function getIncomeReport(\DateTime $start, \DateTime $end)
    {
        return $this->createQueryBuilder('acs')
//            ->select('SUM(acs.total) AS Total')
            ->select('a.fechaLlegada AS fecha')
            ->addSelect('(SUM(CASE WHEN acs.astilleroserviciobasico IS NOT NULL THEN acs.total ELSE 0 END) / 100) AS basicos')
            ->addSelect('(SUM(CASE WHEN acs.producto IS NOT NULL THEN acs.total ELSE 0 END) / 100) AS productos')
            ->addSelect('(SUM(CASE WHEN acs.servicio IS NOT NULL THEN acs.total ELSE 0 END) / 100) AS servicios')
            ->addSelect('(SUM(CASE WHEN '.
                '((acs.servicio IS NULL) AND '.
                '(acs.producto IS NULL) AND '.
                '(acs.astilleroserviciobasico IS NULL)) THEN acs.total ELSE 0 END) / 100) AS otros')
            ->leftJoin('acs.astillerocotizacion', 'a')
            ->where('a.fechaLlegada BETWEEN :start AND :end')
            ->andWhere('acs.estatus = 1 AND a.validacliente = 2')
            ->groupBy('a.fechaLlegada')
            ->orderBy('a.fechaLlegada', 'ASC')
            ->setParameters([
                'start' => $start,
                'end' => $end,
            ])
            ->getQuery()
            ->getScalarResult();
    }

    public function getOneWithCatalogo($id)
    {
        $manager = $this->getEntityManager();

        $cotizacion = $manager->createQuery(
            'SELECT '.
            'cotizacion.cantidad AS conceptoCantidad, cotizacion.total AS conceptoImporte, '.
            'tipo.nombre AS conceptoDescripcion, '.
            'cps.id AS cpsId, cps.descripcion as cpsDescripcion, '.
            'cu.id AS cuId, cu.nombre AS cuDescripcion '.
            'FROM AppBundle:Combustible cotizacion '.
            'LEFT JOIN cotizacion.tipo tipo '.
            'LEFT JOIN tipo.claveProdServ cps '.
            'LEFT JOIN tipo.claveUnidad cu '.
            'WHERE cotizacion.id = :id')
            ->setParameter('id', $id)
            ->getArrayResult();

        return $cotizacion;
    }
}
