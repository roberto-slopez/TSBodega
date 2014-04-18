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
use TS\BodegaBundle\Model\Factura;
use TS\BodegaBundle\Model\FacturaDetalle;
use TS\BodegaBundle\Model\FacturaDetallePeer;
use TS\BodegaBundle\Model\FacturaDetalleQuery;
use TS\BodegaBundle\Model\Producto;

/**
 * @method FacturaDetalleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method FacturaDetalleQuery orderByFacturaId($order = Criteria::ASC) Order by the factura_id column
 * @method FacturaDetalleQuery orderByCantidad($order = Criteria::ASC) Order by the cantidad column
 * @method FacturaDetalleQuery orderByProductoId($order = Criteria::ASC) Order by the producto_id column
 * @method FacturaDetalleQuery orderByPrecioUnitario($order = Criteria::ASC) Order by the precio_unitario column
 * @method FacturaDetalleQuery orderBySubtotal($order = Criteria::ASC) Order by the subtotal column
 *
 * @method FacturaDetalleQuery groupById() Group by the id column
 * @method FacturaDetalleQuery groupByFacturaId() Group by the factura_id column
 * @method FacturaDetalleQuery groupByCantidad() Group by the cantidad column
 * @method FacturaDetalleQuery groupByProductoId() Group by the producto_id column
 * @method FacturaDetalleQuery groupByPrecioUnitario() Group by the precio_unitario column
 * @method FacturaDetalleQuery groupBySubtotal() Group by the subtotal column
 *
 * @method FacturaDetalleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FacturaDetalleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FacturaDetalleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FacturaDetalleQuery leftJoinProducto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Producto relation
 * @method FacturaDetalleQuery rightJoinProducto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Producto relation
 * @method FacturaDetalleQuery innerJoinProducto($relationAlias = null) Adds a INNER JOIN clause to the query using the Producto relation
 *
 * @method FacturaDetalleQuery leftJoinFactura($relationAlias = null) Adds a LEFT JOIN clause to the query using the Factura relation
 * @method FacturaDetalleQuery rightJoinFactura($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Factura relation
 * @method FacturaDetalleQuery innerJoinFactura($relationAlias = null) Adds a INNER JOIN clause to the query using the Factura relation
 *
 * @method FacturaDetalle findOne(PropelPDO $con = null) Return the first FacturaDetalle matching the query
 * @method FacturaDetalle findOneOrCreate(PropelPDO $con = null) Return the first FacturaDetalle matching the query, or a new FacturaDetalle object populated from the query conditions when no match is found
 *
 * @method FacturaDetalle findOneByFacturaId(int $factura_id) Return the first FacturaDetalle filtered by the factura_id column
 * @method FacturaDetalle findOneByCantidad(int $cantidad) Return the first FacturaDetalle filtered by the cantidad column
 * @method FacturaDetalle findOneByProductoId(int $producto_id) Return the first FacturaDetalle filtered by the producto_id column
 * @method FacturaDetalle findOneByPrecioUnitario(string $precio_unitario) Return the first FacturaDetalle filtered by the precio_unitario column
 * @method FacturaDetalle findOneBySubtotal(string $subtotal) Return the first FacturaDetalle filtered by the subtotal column
 *
 * @method array findById(int $id) Return FacturaDetalle objects filtered by the id column
 * @method array findByFacturaId(int $factura_id) Return FacturaDetalle objects filtered by the factura_id column
 * @method array findByCantidad(int $cantidad) Return FacturaDetalle objects filtered by the cantidad column
 * @method array findByProductoId(int $producto_id) Return FacturaDetalle objects filtered by the producto_id column
 * @method array findByPrecioUnitario(string $precio_unitario) Return FacturaDetalle objects filtered by the precio_unitario column
 * @method array findBySubtotal(string $subtotal) Return FacturaDetalle objects filtered by the subtotal column
 */
abstract class BaseFacturaDetalleQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFacturaDetalleQuery object.
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
            $modelName = 'TS\\BodegaBundle\\Model\\FacturaDetalle';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FacturaDetalleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FacturaDetalleQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FacturaDetalleQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FacturaDetalleQuery) {
            return $criteria;
        }
        $query = new FacturaDetalleQuery(null, null, $modelAlias);

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
     * @return   FacturaDetalle|FacturaDetalle[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FacturaDetallePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FacturaDetallePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FacturaDetalle A model object, or null if the key is not found
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
     * @return                 FacturaDetalle A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `factura_id`, `cantidad`, `producto_id`, `precio_unitario`, `subtotal` FROM `factura_detalle` WHERE `id` = :p0';
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
            $obj = new FacturaDetalle();
            $obj->hydrate($row);
            FacturaDetallePeer::addInstanceToPool($obj, (string) $key);
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
     * @return FacturaDetalle|FacturaDetalle[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FacturaDetalle[]|mixed the list of results, formatted by the current formatter
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
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FacturaDetallePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FacturaDetallePeer::ID, $keys, Criteria::IN);
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
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FacturaDetallePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FacturaDetallePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaDetallePeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the factura_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFacturaId(1234); // WHERE factura_id = 1234
     * $query->filterByFacturaId(array(12, 34)); // WHERE factura_id IN (12, 34)
     * $query->filterByFacturaId(array('min' => 12)); // WHERE factura_id >= 12
     * $query->filterByFacturaId(array('max' => 12)); // WHERE factura_id <= 12
     * </code>
     *
     * @see       filterByFactura()
     *
     * @param     mixed $facturaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function filterByFacturaId($facturaId = null, $comparison = null)
    {
        if (is_array($facturaId)) {
            $useMinMax = false;
            if (isset($facturaId['min'])) {
                $this->addUsingAlias(FacturaDetallePeer::FACTURA_ID, $facturaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($facturaId['max'])) {
                $this->addUsingAlias(FacturaDetallePeer::FACTURA_ID, $facturaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaDetallePeer::FACTURA_ID, $facturaId, $comparison);
    }

    /**
     * Filter the query on the cantidad column
     *
     * Example usage:
     * <code>
     * $query->filterByCantidad(1234); // WHERE cantidad = 1234
     * $query->filterByCantidad(array(12, 34)); // WHERE cantidad IN (12, 34)
     * $query->filterByCantidad(array('min' => 12)); // WHERE cantidad >= 12
     * $query->filterByCantidad(array('max' => 12)); // WHERE cantidad <= 12
     * </code>
     *
     * @param     mixed $cantidad The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function filterByCantidad($cantidad = null, $comparison = null)
    {
        if (is_array($cantidad)) {
            $useMinMax = false;
            if (isset($cantidad['min'])) {
                $this->addUsingAlias(FacturaDetallePeer::CANTIDAD, $cantidad['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cantidad['max'])) {
                $this->addUsingAlias(FacturaDetallePeer::CANTIDAD, $cantidad['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaDetallePeer::CANTIDAD, $cantidad, $comparison);
    }

    /**
     * Filter the query on the producto_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductoId(1234); // WHERE producto_id = 1234
     * $query->filterByProductoId(array(12, 34)); // WHERE producto_id IN (12, 34)
     * $query->filterByProductoId(array('min' => 12)); // WHERE producto_id >= 12
     * $query->filterByProductoId(array('max' => 12)); // WHERE producto_id <= 12
     * </code>
     *
     * @see       filterByProducto()
     *
     * @param     mixed $productoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function filterByProductoId($productoId = null, $comparison = null)
    {
        if (is_array($productoId)) {
            $useMinMax = false;
            if (isset($productoId['min'])) {
                $this->addUsingAlias(FacturaDetallePeer::PRODUCTO_ID, $productoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productoId['max'])) {
                $this->addUsingAlias(FacturaDetallePeer::PRODUCTO_ID, $productoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaDetallePeer::PRODUCTO_ID, $productoId, $comparison);
    }

    /**
     * Filter the query on the precio_unitario column
     *
     * Example usage:
     * <code>
     * $query->filterByPrecioUnitario(1234); // WHERE precio_unitario = 1234
     * $query->filterByPrecioUnitario(array(12, 34)); // WHERE precio_unitario IN (12, 34)
     * $query->filterByPrecioUnitario(array('min' => 12)); // WHERE precio_unitario >= 12
     * $query->filterByPrecioUnitario(array('max' => 12)); // WHERE precio_unitario <= 12
     * </code>
     *
     * @param     mixed $precioUnitario The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function filterByPrecioUnitario($precioUnitario = null, $comparison = null)
    {
        if (is_array($precioUnitario)) {
            $useMinMax = false;
            if (isset($precioUnitario['min'])) {
                $this->addUsingAlias(FacturaDetallePeer::PRECIO_UNITARIO, $precioUnitario['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($precioUnitario['max'])) {
                $this->addUsingAlias(FacturaDetallePeer::PRECIO_UNITARIO, $precioUnitario['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaDetallePeer::PRECIO_UNITARIO, $precioUnitario, $comparison);
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
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function filterBySubtotal($subtotal = null, $comparison = null)
    {
        if (is_array($subtotal)) {
            $useMinMax = false;
            if (isset($subtotal['min'])) {
                $this->addUsingAlias(FacturaDetallePeer::SUBTOTAL, $subtotal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subtotal['max'])) {
                $this->addUsingAlias(FacturaDetallePeer::SUBTOTAL, $subtotal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaDetallePeer::SUBTOTAL, $subtotal, $comparison);
    }

    /**
     * Filter the query by a related Producto object
     *
     * @param   Producto|PropelObjectCollection $producto The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FacturaDetalleQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProducto($producto, $comparison = null)
    {
        if ($producto instanceof Producto) {
            return $this
                ->addUsingAlias(FacturaDetallePeer::PRODUCTO_ID, $producto->getId(), $comparison);
        } elseif ($producto instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FacturaDetallePeer::PRODUCTO_ID, $producto->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProducto() only accepts arguments of type Producto or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Producto relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function joinProducto($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Producto');

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
            $this->addJoinObject($join, 'Producto');
        }

        return $this;
    }

    /**
     * Use the Producto relation Producto object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TS\BodegaBundle\Model\ProductoQuery A secondary query class using the current class as primary query
     */
    public function useProductoQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProducto($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Producto', '\TS\BodegaBundle\Model\ProductoQuery');
    }

    /**
     * Filter the query by a related Factura object
     *
     * @param   Factura|PropelObjectCollection $factura The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FacturaDetalleQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFactura($factura, $comparison = null)
    {
        if ($factura instanceof Factura) {
            return $this
                ->addUsingAlias(FacturaDetallePeer::FACTURA_ID, $factura->getId(), $comparison);
        } elseif ($factura instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FacturaDetallePeer::FACTURA_ID, $factura->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFactura() only accepts arguments of type Factura or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Factura relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function joinFactura($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Factura');

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
            $this->addJoinObject($join, 'Factura');
        }

        return $this;
    }

    /**
     * Use the Factura relation Factura object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TS\BodegaBundle\Model\FacturaQuery A secondary query class using the current class as primary query
     */
    public function useFacturaQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFactura($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Factura', '\TS\BodegaBundle\Model\FacturaQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   FacturaDetalle $facturaDetalle Object to remove from the list of results
     *
     * @return FacturaDetalleQuery The current query, for fluid interface
     */
    public function prune($facturaDetalle = null)
    {
        if ($facturaDetalle) {
            $this->addUsingAlias(FacturaDetallePeer::ID, $facturaDetalle->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
