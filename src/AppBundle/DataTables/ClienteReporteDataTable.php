<?php
/**
 * Created by PhpStorm.
 * User: inrumi
 * Date: 3/29/18
 * Time: 15:52
 */

namespace AppBundle\DataTables;


use AppBundle\Entity\Cliente;
use DataTables\AbstractDataTableHandler;
use DataTables\DataTableException;
use DataTables\DataTableQuery;
use DataTables\DataTableResults;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Driver\PDOConnection;

class ClienteReporteDataTable extends AbstractDataTableHandler
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Handles specified DataTable request.
     *
     * @param DataTableQuery $request
     *
     * @throws DataTableException
     *
     * @return DataTableResults
     */
    public function handle(DataTableQuery $request): DataTableResults
    {
        $results = new DataTableResults();
        $repository = $this->doctrine->getRepository(Cliente::class);

        $cliente = $request->customData['cliente'];
        $results->recordsTotal = $repository->getCotizacionesCount($cliente);

        $queryContent =
            'SELECT cotizacion.id,
                     \'Marina\'               AS tipo,
                     DATE_FORMAT(cotizacion.fecharegistro, \'%d-%m-%Y\') AS fecha,
                     cotizacion.folio,
                     cotizacion.foliorecotiza,
                     (cotizacion.total  * (cotizacion.dolar / 100)) AS total,
                     cotizacion.idcliente     AS cliente,
                     cotizacion.validacliente AS validacion
              FROM marina_humeda_cotizacion cotizacion
              UNION
              SELECT cotizacion.id,
              \'Astillero\' AS tipo,
                     DATE_FORMAT(cotizacion.fecharegistro, \'%d-%m-%Y\') AS fecha,
                     cotizacion.folio,
                     cotizacion.foliorecotiza,
                     cotizacion.total AS total,
                     cotizacion.cliente_id    AS cliente,
                     cotizacion.validacliente AS validacion
              FROM astillero_cotizacion cotizacion
              UNION
              SELECT cotizacion.id,
                     \'Combustible\'          AS tipo,
                     DATE_FORMAT(cotizacion.fecha, \'%d-%m-%Y\') AS fecha,
                     cotizacion.folio,
                     cotizacion.foliorecotiza,
                     cotizacion.total AS total,
                     cotizacion.idcliente     AS cliente,
                     cotizacion.validacliente AS validacion
              FROM combustible cotizacion) AS cotizaciones
              WHERE cotizaciones.cliente = :cliente
              AND cotizaciones.validacion = 2 ';

        if ($request->search->value) {
            $queryContent .= 'AND (LOWER(cotizaciones.tipo) LIKE :search OR '.
                'LOWER(cotizaciones.folio) LIKE :search) ';
        }

        foreach ($request->order as $order) {
            if ($order->column == 0) {
                $queryContent .= "ORDER BY cotizaciones.fecha {$order->dir} ";
            } elseif ($order->column == 1) {
                $queryContent .= "ORDER BY cotizaciones.folio {$order->dir} ";
            } elseif ($order->column == 2) {
                $queryContent .= "ORDER BY cotizaciones.total {$order->dir} ";
            } elseif ($order->column == 3) {
                $queryContent .= "ORDER BY cotizaciones.id {$order->dir} ";
            }
        }

        /** @var PDOConnection $connection */
        $connection = $this->doctrine->getConnection();

        $queryCount = 'SELECT COUNT(cotizaciones.id) AS c, SUM(cotizaciones.total) AS t FROM ('.$queryContent;
        $statement = $connection->prepare($queryCount);
        $statement->bindValue('cliente', $cliente, \PDO::PARAM_INT);

        if ($request->search->value) {
            $statement->bindValue('search', strtolower("%{$request->search->value}%"));
        }

        $statement->execute();
        $dataCount = $statement->fetch();

        $results->recordsFiltered = $dataCount['c'];

        $query = 'SELECT * FROM ('.$queryContent;

        if ($request->length > 0) {
            $query .= ' LIMIT :limit, :offset';
        }

        $statement = $connection->prepare($query);
        $statement->bindParam('cliente', $cliente, \PDO::PARAM_INT);

        if ($request->search->value) {
            $statement->bindValue('search', strtolower("%{$request->search->value}%"));
        }

        if ($request->length > 0) {
            $statement->bindValue('limit', $request->start, \PDO::PARAM_INT);
            $statement->bindValue('offset', $request->length, \PDO::PARAM_INT);
        }

        $statement->execute();

        $cotizaciones = $statement->fetchAll();

        foreach ($cotizaciones as $cotizacion) {
            $folio = $cotizacion['foliorecotiza']
                ? $cotizacion['folio'].'-'.$cotizacion['foliorecotiza']
                : $cotizacion['folio'];

            $results->data[] = [
                $cotizacion['fecha'],
                "Cotizacion {$cotizacion['tipo']} #{$folio}",
                'MX $'.number_format(($cotizacion['total'] / 100), 2),
                [
                    'id' => $cotizacion['id'],
                    'adeudo' => number_format(($dataCount['t'] / 100), 2),
                ],
            ];
        }

        return $results;
    }
}
