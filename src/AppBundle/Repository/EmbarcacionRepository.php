<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * EmbarcacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmbarcacionRepository extends EntityRepository
{
    public function findAllLight()
    {
        $qb = $this->createQueryBuilder('em');

        $qb->select('em', 'ma', 'mo', 'pa')
            ->leftJoin('em.marca', 'ma')
            ->leftJoin('em.modelo', 'mo')
            ->leftJoin('em.pais', 'pa');

        return $qb->getQuery()->getResult();
    }

    public function findAnos()
    {
        $qb = $this->createQueryBuilder('em');

        return $qb->select('em.ano as nombre')
            ->getQuery()
            ->getResult();
    }

    public function findPaises()
    {
        $qb = $this->createQueryBuilder('em');

        return $qb->select('pa.name as nombre')
            ->leftJoin('em.pais', 'pa')
            ->getQuery()
            ->getResult();
    }

    public function findMarcas()
    {
        $qb = $this->createQueryBuilder('em');

        return $qb->select('ma.nombre')
            ->leftJoin('em.marca', 'ma')
            ->getQuery()
            ->getResult();
    }

    public function findModelos()
    {
        $qb = $this->createQueryBuilder('em');

        return $qb->select('mo.nombre')
            ->leftJoin('em.modelo', 'mo')
            ->getQuery()
            ->getResult();
    }

    public function findCategorias()
    {
        $qb = $this->createQueryBuilder('em');

        return $qb->select('em.categoria as nombre')
            ->getQuery()
            ->getResult();
    }
    public function filtrarBarcos($request)
    {
        $idembarcacion = $request->get('idembarcacion');
        $idcategoria = $request->get('idcategoria');
        $anio = $request->get('anio');
        $idmarca = $request->get('idmarca');
        $buscarPrecio = $request->get('buscarPrecio');
        $precioMenor = $request->get('precioMenor');
        $precioMayor = $request->get('precioMayor');
        $idpais = $request->get('idpais');

        $em = $this->createQueryBuilder('e');
        $em ->select('e','EmbarcacionImagen','EmbarcacionLayout','EmbarcacionMarca','EmbarcacionModelo','Pais')
            ->leftJoin('e.imagenes','EmbarcacionImagen')
            ->leftJoin('e.layouts','EmbarcacionLayout')
            ->leftJoin('e.marca','EmbarcacionMarca')
            ->leftJoin('e.modelo','EmbarcacionModelo')
            ->leftJoin('e.pais','Pais');

        if($idembarcacion !== '0'){
            $em ->andWhere($em->expr()->eq('e.id',':idembarcacion'))
                ->setParameter('idembarcacion',$idembarcacion);
        }
        if($idcategoria !== '0'){
            $em ->andWhere($em->expr()->eq('e.categoria',':idcategoria'))
                ->setParameter('idcategoria',$idcategoria);
        }
        if($anio !== '0'){
            $em ->andWhere($em->expr()->eq('e.ano',':anio'))
                ->setParameter('anio',$anio);
        }
        if($idmarca !== '0'){
            $em ->andWhere($em->expr()->eq('e.marca',':idmarca'))
                ->setParameter('idmarca',$idmarca);
        }
        if($buscarPrecio !== '0'){
            $em ->andWhere($em->expr()->between('e.precio',':menor',':mayor'))
                ->setParameter('menor',$precioMenor)
                ->setParameter('mayor',$precioMayor);
        }
        if($idpais !== '0'){
            $em ->andWhere($em->expr()->eq('e.pais',':idpais'))
                ->setParameter('idpais',$idpais);
        }
        $embarcaciones = $em->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return $embarcaciones;
    }

    public function encuentraAniosUnicos()
    {
        $qb = $this->createQueryBuilder('a');

        return $qb->select('a.ano as id','a.ano as nombre')
            ->groupBy('nombre')
            ->orderBy('nombre','DESC')
            ->getQuery()
            ->getResult();
    }

}
