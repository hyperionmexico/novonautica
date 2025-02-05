<?php

namespace AppBundle\Repository\Astillero;

/**
 * ProductoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductoRepository extends \Doctrine\ORM\EntityRepository
{
    function obtenerProducto($idproducto)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p.id, p.existencia, p.nombre, p.precio, p.unidad, p.identificador '.
                'FROM AppBundle:Astillero\Producto p '.
                'WHERE p.id = :id'
            )
            ->setParameter('id', $idproducto);

        return $query->getArrayResult()[0];
    }

    public function getProductoSelect2($query)
    {
        $builder = $this->createQueryBuilder('producto');

        return $builder
            ->select('producto.id, producto.nombre AS text, producto.existencia AS quantity')
            ->where('LOWER(producto.nombre) LIKE :query')
            ->setParameter('query', strtolower("%{$query}%"))
            ->setMaxResults(5)
            ->getQuery()
            ->getArrayResult();
    }
}
