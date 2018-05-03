<?php

namespace AppBundle\Repository;

/**
 * MarinaHumedaCotizacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MarinaHumedaCotizacionRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllEstadia()
    {
        $qb = $this->createQueryBuilder('mhc');

        return $qb
            ->select('mhc', 'servicios')
            ->join('mhc.mhcservicios', 'servicios')
            ->where($qb->expr()->neq('servicios.tipo', '3'))
            ->getQuery()
            ->getResult();
    }

    public function findAllGasolina()
    {
        $qb = $this->createQueryBuilder('mhc');

        return $qb
            ->select('mhc', 'servicios')
            ->join('mhc.mhcservicios', 'servicios')
            ->where($qb->expr()->eq('servicios.tipo','3'))
            ->orWhere($qb->expr()->eq('servicios.tipo','4'))
            ->orWhere($qb->expr()->eq('servicios.tipo','5'))
            ->getQuery()
            ->getResult();
    }

    public function getAllClientes()
    {
        $qb = $this->createQueryBuilder('mhce');

        return $qb
            ->select('cliente.nombre AS nombre')
            ->join('mhce.cliente', 'cliente')
            ->join('mhce.mhcservicios', 'servicios')
            ->where($qb->expr()->neq('servicios.tipo','3'))
            ->distinct()
            ->getQuery()
            ->getResult();
    }

    public function getAllBarcos()
    {
        $qb = $this->createQueryBuilder('mhce');

        return $qb
            ->select('barco.nombre AS nombre')
            ->join('mhce.barco', 'barco')
            ->join('mhce.mhcservicios', 'servicios')
            ->where($qb->expr()->neq('servicios.tipo','3'))
            ->distinct()
            ->getQuery()
            ->getResult();
    }

    public function getAllValidas()
    {
        $qb = $this->createQueryBuilder('mhce');

        return $qb
            ->select('mhce.validanovo AS nombre')
            ->join('mhce.mhcservicios', 'servicios')
            ->where($qb->expr()->neq('servicios.tipo','3'))
            ->distinct()
            ->getQuery()
            ->getResult();
    }

    public function getCotizacionByFolio($folio)
    {
        $folios = explode('-', $folio);

        $qb = $this->createQueryBuilder('mhc');

        $qb->where('mhc.folio = :folio')
            ->setParameter('folio', $folios[0]);

        if (isset($folios[1])) {
            $qb->andWhere('mhc.foliorecotiza = :foliorecotiza')
                ->setParameter('foliorecotiza', $folios[1]);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return string
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getMostDebtor()
    {
        return $this->createQueryBuilder('mc')
            ->leftJoin('mc.cliente', 'c')
            ->select('c.nombre', 'SUM(mc.total) AS adeudo', 'SUM(mc.pagado) AS abono')
            ->where('mc.validacliente = 2')
            ->groupBy('c.id')
            ->orderBy('adeudo', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }

    public function getCotizacionHistoryByDateRange($start, $end, $novoResponse, $clientResponse)
    {
        $query = $this->createQueryBuilder('mc')
            ->select(
                'SUBSTRING(mc.fecharegistro, 1, 10) AS fecha',
                'COUNT(mc.fechaLlegada) AS estadias',
                'SUM(CASE WHEN mc.fechaLlegada IS NULL THEN 1 ELSE 0 END) AS gasolinas'
            )
            ->where('mc.fecharegistro BETWEEN :start AND :end')
            ->groupBy('fecha')
            ->setParameters([
                'start' => $start,
                'end' => $end,
            ])
            ->orderBy('mc.fecharegistro');

        if ($novoResponse) {
            $query->andWhere('mc.validanovo = :novoResponse');
            $query->setParameter('novoResponse', $novoResponse);
        }

        if ($novoResponse && $clientResponse) {
            $query->andWhere('mc.validacliente = :clientResponse');
            $query->setParameter('clientResponse', $clientResponse);
        }

        return $query->getQuery()->getScalarResult();
    }

    public function getWorkedBoatsByDaterange(\DateTime $start, \DateTime $end)
    {
        return $this->createQueryBuilder('mc')
            ->select('mc.fechaLlegada AS fecha' ,'COUNT(mc.id) AS total')
            ->where('mc.fechaLlegada BETWEEN :start AND :end')
            ->andWhere('mc.validacliente = 2')
            ->setParameters([
                'start' => $start,
                'end' => $end,
            ])
            ->groupBy('mc.fechaLlegada')
            ->orderBy('mc.fechaLlegada', 'ASC')
            ->getQuery()
            ->getScalarResult();
    }
}
