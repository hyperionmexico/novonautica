<?php

namespace AppBundle\Repository\Contabilidad\Facturacion;

/**
 * PagoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PagoRepository extends \Doctrine\ORM\EntityRepository
{
    public function getTotalPagadoEnFactura($factura)
    {
        $manager = $this->getEntityManager();

        $total = $manager->createQuery(
            'SELECT (COUNT(pago.id) + 1) AS parcialidad, SUM(pago.montoPagos) AS pagado '.
            'FROM AppBundle:Contabilidad\Facturacion\Pago pago '.
            'WHERE IDENTITY(pago.factura) = ?1 '.
            'AND pago.isCancelado = 0')
            ->setParameter(1, $factura)
            ->getSingleResult();

        return $total;
    }
}
