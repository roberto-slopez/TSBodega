<?php

namespace TS\BodegaBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use TS\BodegaBundle\Model\Clientes;
use TS\BodegaBundle\Model\Compras;
use TS\BodegaBundle\Model\Factura;
use TS\BodegaBundle\Model\FacturaDetalle;
use TS\BodegaBundle\Model\FacturaPeer;
use TS\BodegaBundle\Model\FacturaQuery;
use TS\BodegaBundle\Model\Ventas;

/**
 * @method FacturaQuery orderById($order = Criteria::ASC) Order by the id column
 * @method FacturaQuery orderByNumeroFactura($order = Criteria::ASC) Order by the numero_factura column
 * @method FacturaQuery orderByFecha($order = Criteria::ASC) Order by the fecha column
 * @method FacturaQuery orderByTipo($order = Criteria::ASC) Order by the tipo column
 * @method FacturaQuery orderByClientesId($order = Criteria::ASC) Order by the clientes_id column
 * @method FacturaQuery orderBySubtotal($order = Criteria::ASC) Order by the subtotal column
 * @method FacturaQuery orderByImpuesto($order = Criteria::ASC) Order by the impuesto column
 * @method FacturaQuery orderByDescuento($order = Criteria::ASC) Order by the descuento column
 * @method FacturaQuery orderByTotal($order = Criteria::ASC) Order by the total column
 *
 * @method FacturaQuery groupById() Group by the id column
 * @method FacturaQuery groupByNumeroFactura() Group by the numero_factura column
 * @method FacturaQuery groupByFecha() Group by the fecha column
 * @method FacturaQuery groupByTipo() Group by the tipo column
 * @method FacturaQuery groupByClientesId() Group by the clientes_id column
 * @method FacturaQuery groupBySubtotal() Group by the subtotal column
 * @method FacturaQuery groupByImpuesto() Group by the impuesto column
 * @method FacturaQuery groupByDescuento() Group by the descuento column
 * @method FacturaQuery groupByTotal() Group by the total column
 *
 * @method FacturaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FacturaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FacturaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FacturaQuery leftJoinClientes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Clientes relation
 * @method FacturaQuery rightJoinClientes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Clientes relation
 * @method FacturaQuery innerJoinClientes($relationAlias = null) Adds a INNER JOIN clause to the query using the Clientes relation
 *
 * @method FacturaQuery leftJoinCompras($relationAlias = null) Adds a LEFT JOIN clause to the query using the Compras relation
 * @method FacturaQuery rightJoinCompras($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Compras relation
 * @method FacturaQuery innerJoinCompras($relationAlias = null) Adds a INNER JOIN clause to the query using the Compras relation
 *
 * @method FacturaQuery leftJoinVentas($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ventas relation
 * @method FacturaQuery rightJoinVentas($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ventas relation
 * @method FacturaQuery innerJoinVentas($relationAlias = null) Adds a INNER JOIN clause to the query using the Ventas relation
 *
 * @method FacturaQuery leftJoinFacturaDetalle($relationAlias = null) Adds a LEFT JOIN clause to the query using the FacturaDetalle relation
 * @method FacturaQuery rightJoinFacturaDetalle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FacturaDetalle relation
 * @method FacturaQuery innerJoinFacturaDetalle($relationAlias = null) Adds a INNER JOIN clause to the query using the FacturaDetalle relation
 *
 * @method Factura findOne(PropelPDO $con = null) Return the first Factura matching the query
 * @method Factura findOneOrCreate(PropelPDO $con = null) Return the first Factura matching the query, or a new Factura object populated from the query conditions when no match is found
 *
 * @method Factura findOneByNumeroFactura(string $numero_factura) Return the first Factura filtered by the numero_factura column
 * @method Factura findOneByFecha(string $fecha) Return the first Factura filtered by the fecha column
 * @method Factura findOneByTipo(string $tipo) Return the first Factura filtered by the tipo column
 * @method Factura findOneByClientesId(int $clientes_id) Return the first Factura filtered by the clientes_id column
 * @method Factura findOneBySubtotal(string $subtotal) Return the first Factura filtered by the subtotal column
 * @method Factura findOneByImpuesto(string $impuesto) Return the first Factura filtered by the impuesto column
 * @method Factura findOneByDescuento(string $descuento) Return the first Factura filtered by the descuento column
 * @method Factura findOneByTotal(string $total) Return the first Factura filtered by the total column
 *
 * @method array findById(int $id) Return Factura objects filtered by the id column
 * @method array findByNumeroFactura(string $numero_factura) Return Factura objects filtered by the numero_factura column
 * @method array findByFecha(string $fecha) Return Factura objects filtered by the fecha column
 * @method array findByTipo(string $tipo) Return Factura objects filtered by the tipo column
 * @method array findByClientesId(int $clientes_id) Return Factura objects filtered by the clientes_id column
 * @method array findBySubtotal(string $subtotal) Return Factura objects filtered by the subtotal column
 * @method array findByImpuesto(string $impuesto) Return Factura objects filtered by the impuesto column
 * @method array findByDescuento(string $descuento) Return Factura objects filtered by the descuento column
 * @method array findByTotal(string $total) Return Factura objects filtered by the total column
 */
abstract class BaseFacturaQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFacturaQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'TS\\BodegaBundle\\Model\\Factura';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FacturaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FacturaQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FacturaQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FacturaQuery) {
            return $criteria;
        }
        $query = new FacturaQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Factura|Factura[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FacturaPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FacturaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Factura A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Factura A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `numero_factura`, `fecha`, `tipo`, `clientes_id`, `subtotal`, `impuesto`, `descuento`, `total` FROM `factura` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Factura();
            $obj->hydrate($row);
            FacturaPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Factura|Factura[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Factura[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FacturaPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FacturaPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FacturaPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FacturaPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the numero_factura column
     *
     * Example usage:
     * <code>
     * $query->filterByNumeroFactura('fooValue');   // WHERE numero_factura = 'fooValue'
     * $query->filterByNumeroFactura('%fooValue%'); // WHERE numero_factura LIKE '%fooValue%'
     * </code>
     *
     * @param     string $numeroFactura The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterByNumeroFactura($numeroFactura = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($numeroFactura)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $numeroFactura)) {
                $numeroFactura = str_replace('*', '%', $numeroFactura);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FacturaPeer::NUMERO_FACTURA, $numeroFactura, $comparison);
    }

    /**
     * Filter the query on the fecha column
     *
     * Example usage:
     * <code>
     * $query->filterByFecha('2011-03-14'); // WHERE fecha = '2011-03-14'
     * $query->filterByFecha('now'); // WHERE fecha = '2011-03-14'
     * $query->filterByFecha(array('max' => 'yesterday')); // WHERE fecha < '2011-03-13'
     * </code>
     *
     * @param     mixed $fecha The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterByFecha($fecha = null, $comparison = null)
    {
        if (is_array($fecha)) {
            $useMinMax = false;
            if (isset($fecha['min'])) {
                $this->addUsingAlias(FacturaPeer::FECHA, $fecha['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fecha['max'])) {
                $this->addUsingAlias(FacturaPeer::FECHA, $fecha['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaPeer::FECHA, $fecha, $comparison);
    }

    /**
     * Filter the query on the tipo column
     *
     * Example usage:
     * <code>
     * $query->filterByTipo('fooValue');   // WHERE tipo = 'fooValue'
     * $query->filterByTipo('%fooValue%'); // WHERE tipo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tipo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterByTipo($tipo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tipo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tipo)) {
                $tipo = str_replace('*', '%', $tipo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FacturaPeer::TIPO, $tipo, $comparison);
    }

    /**
     * Filter the query on the clientes_id column
     *
     * Example usage:
     * <code>
     * $query->filterByClientesId(1234); // WHERE clientes_id = 1234
     * $query->filterByClientesId(array(12, 34)); // WHERE clientes_id IN (12, 34)
     * $query->filterByClientesId(array('min' => 12)); // WHERE clientes_id >= 12
     * $query->filterByClientesId(array('max' => 12)); // WHERE clientes_id <= 12
     * </code>
     *
     * @see       filterByClientes()
     *
     * @param     mixed $clientesId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterByClientesId($clientesId = null, $comparison = null)
    {
        if (is_array($clientesId)) {
            $useMinMax = false;
            if (isset($clientesId['min'])) {
                $this->addUsingAlias(FacturaPeer::CLIENTES_ID, $clientesId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clientesId['max'])) {
                $this->addUsingAlias(FacturaPeer::CLIENTES_ID, $clientesId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaPeer::CLIENTES_ID, $clientesId, $comparison);
    }

    /**
     * Filter the query on the subtotal column
     *
     * Example usage:
     * <code>
     * $query->filterBySubtotal(1234); // WHERE subtotal = 1234
     * $query->filterBySubtotal(array(12, 34)); // WHERE subtotal IN (12, 34)
     * $query->filterBySubtotal(array('min' => 12)); // WHERE subtotal >= 12
     * $query->filterBySubtotal(array('max' => 12)); // WHERE subtotal <= 12
     * </code>
     *
     * @param     mixed $subtotal The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterBySubtotal($subtotal = null, $comparison = null)
    {
        if (is_array($subtotal)) {
            $useMinMax = false;
            if (isset($subtotal['min'])) {
                $this->addUsingAlias(FacturaPeer::SUBTOTAL, $subtotal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subtotal['max'])) {
                $this->addUsingAlias(FacturaPeer::SUBTOTAL, $subtotal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaPeer::SUBTOTAL, $subtotal, $comparison);
    }

    /**
     * Filter the query on the impuesto column
     *
     * Example usage:
     * <code>
     * $query->filterByImpuesto(1234); // WHERE impuesto = 1234
     * $query->filterByImpuesto(array(12, 34)); // WHERE impuesto IN (12, 34)
     * $query->filterByImpuesto(array('min' => 12)); // WHERE impuesto >= 12
     * $query->filterByImpuesto(array('max' => 12)); // WHERE impuesto <= 12
     * </code>
     *
     * @param     mixed $impuesto The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterByImpuesto($impuesto = null, $comparison = null)
    {
        if (is_array($impuesto)) {
            $useMinMax = false;
            if (isset($impuesto['min'])) {
                $this->addUsingAlias(FacturaPeer::IMPUESTO, $impuesto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($impuesto['max'])) {
                $this->addUsingAlias(FacturaPeer::IMPUESTO, $impuesto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaPeer::IMPUESTO, $impuesto, $comparison);
    }

    /**
     * Filter the query on the descuento column
     *
     * Example usage:
     * <code>
     * $query->filterByDescuento(1234); // WHERE descuento = 1234
     * $query->filterByDescuento(array(12, 34)); // WHERE descuento IN (12, 34)
     * $query->filterByDescuento(array('min' => 12)); // WHERE descuento >= 12
     * $query->filterByDescuento(array('max' => 12)); // WHERE descuento <= 12
     * </code>
     *
     * @param     mixed $descuento The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterByDescuento($descuento = null, $comparison = null)
    {
        if (is_array($descuento)) {
            $useMinMax = false;
            if (isset($descuento['min'])) {
                $this->addUsingAlias(FacturaPeer::DESCUENTO, $descuento['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($descuento['max'])) {
                $this->addUsingAlias(FacturaPeer::DESCUENTO, $descuento['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaPeer::DESCUENTO, $descuento, $comparison);
    }

    /**
     * Filter the query on the total column
     *
     * Example usage:
     * <code>
     * $query->filterByTotal(1234); // WHERE total = 1234
     * $query->filterByTotal(array(12, 34)); // WHERE total IN (12, 34)
     * $query->filterByTotal(array('min' => 12)); // WHERE total >= 12
     * $query->filterByTotal(array('max' => 12)); // WHERE total <= 12
     * </code>
     *
     * @param     mixed $total The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function filterByTotal($total = null, $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(FacturaPeer::TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(FacturaPeer::TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaPeer::TOTAL, $total, $comparison);
    }

    /**
     * Filter the query by a related Clientes object
     *
     * @param   Clientes|PropelObjectCollection $clientes The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FacturaQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByClientes($clientes, $comparison = null)
    {
        if ($clientes instanceof Clientes) {
            return $this
                ->addUsingAlias(FacturaPeer::CLIENTES_ID, $clientes->getId(), $comparison);
        } elseif ($clientes instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FacturaPeer::CLIENTES_ID, $clientes->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByClientes() only accepts arguments of type Clientes or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Clientes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function joinClientes($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Clientes');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Clientes');
        }

        return $this;
    }

    /**
     * Use the Clientes relation Clientes object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TS\BodegaBundle\Model\ClientesQuery A secondary query class using the current class as primary query
     */
    public function useClientesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinClientes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Clientes', '\TS\BodegaBundle\Model\ClientesQuery');
    }

    /**
     * Filter the query by a related Compras object
     *
     * @param   Compras|PropelObjectCollection $compras  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FacturaQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCompras($compras, $comparison = null)
    {
        if ($compras instanceof Compras) {
            return $this
                ->addUsingAlias(FacturaPeer::ID, $compras->getFacturaId(), $comparison);
        } elseif ($compras instanceof PropelObjectCollection) {
            return $this
                ->useComprasQuery()
                ->filterByPrimaryKeys($compras->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCompras() only accepts arguments of type Compras or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Compras relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function joinCompras($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Compras');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Compras');
        }

        return $this;
    }

    /**
     * Use the Compras relation Compras object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TS\BodegaBundle\Model\ComprasQuery A secondary query class using the current class as primary query
     */
    public function useComprasQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCompras($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Compras', '\TS\BodegaBundle\Model\ComprasQuery');
    }

    /**
     * Filter the query by a related Ventas object
     *
     * @param   Ventas|PropelObjectCollection $ventas  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FacturaQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByVentas($ventas, $comparison = null)
    {
        if ($ventas instanceof Ventas) {
            return $this
                ->addUsingAlias(FacturaPeer::ID, $ventas->getFacturaId(), $comparison);
        } elseif ($ventas instanceof PropelObjectCollection) {
            return $this
                ->useVentasQuery()
                ->filterByPrimaryKeys($ventas->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVentas() only accepts arguments of type Ventas or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Ventas relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function joinVentas($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Ventas');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Ventas');
        }

        return $this;
    }

    /**
     * Use the Ventas relation Ventas object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TS\BodegaBundle\Model\VentasQuery A secondary query class using the current class as primary query
     */
    public function useVentasQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVentas($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Ventas', '\TS\BodegaBundle\Model\VentasQuery');
    }

    /**
     * Filter the query by a related FacturaDetalle object
     *
     * @param   FacturaDetalle|PropelObjectCollection $facturaDetalle  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FacturaQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFacturaDetalle($facturaDetalle, $comparison = null)
    {
        if ($facturaDetalle instanceof FacturaDetalle) {
            return $this
                ->addUsingAlias(FacturaPeer::ID, $facturaDetalle->getFacturaId(), $comparison);
        } elseif ($facturaDetalle instanceof PropelObjectCollection) {
            return $this
                ->useFacturaDetalleQuery()
                ->filterByPrimaryKeys($facturaDetalle->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFacturaDetalle() only accepts arguments of type FacturaDetalle or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FacturaDetalle relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function joinFacturaDetalle($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FacturaDetalle');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FacturaDetalle');
        }

        return $this;
    }

    /**
     * Use the FacturaDetalle relation FacturaDetalle object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TS\BodegaBundle\Model\FacturaDetalleQuery A secondary query class using the current class as primary query
     */
    public function useFacturaDetalleQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFacturaDetalle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FacturaDetalle', '\TS\BodegaBundle\Model\FacturaDetalleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Factura $factura Object to remove from the list of results
     *
     * @return FacturaQuery The current query, for fluid interface
     */
    public function prune($factura = null)
    {
        if ($factura) {
            $this->addUsingAlias(FacturaPeer::ID, $factura->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
