<?php
/**
 * Created by PhpStorm.
 * User: inrumi
 * Date: 3/29/18
 * Time: 12:17
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\Cliente\Reporte;
use AppBundle\Entity\MarinaHumedaCotizacion;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class ReporteMarinaListener implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [Events::postUpdate];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof MarinaHumedaCotizacion) {
            return;
        }

        if ($entity->getEstatuspago()) {
            return;
        }

        if ($entity->getValidacliente() !== 2) {
            return;
        }

        $em = $args->getObjectManager();
        $folio = $entity->getFoliorecotiza() ? "{$entity->getFolio()}-{$entity->getFoliorecotiza()}" : $entity->getFolio();

        $reporte = new Reporte();
        $reporte->setAdeudo($entity->getTotal());
        $reporte->setCliente($entity->getBarco()->getCliente());
        $reporte->setConcepto("Cotizacion Marina #{$folio}");
        $reporte->setReferencia($folio);

        $em->persist($reporte);
        $em->flush();
    }
}