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
use TS\BodegaBundle\Model\Compras;
use TS\BodegaBundle\Model\Inventario;
use TS\BodegaBundle\Model\InventarioPeer;
use TS\BodegaBundle\Model\InventarioQuery;
use TS\BodegaBundle\Model\Producto;
use TS\BodegaBundle\Model\Proveedor;
use TS\BodegaBundle\Model\Ventas;

/**
 * @method InventarioQuery orderById($order = Criteria::ASC) Order by the id column
 * @method InventarioQuery orderByProductoId($order = Criteria::ASC) Order by the producto_id column
 * @method InventarioQuery orderByProveedorId($order = Criteria::ASC) Order by the proveedor_id column
 * @method InventarioQuery orderByFecha($order = Criteria::ASC) Order by the fecha column
 * @method InventarioQuery orderByStock($order = Criteria::ASC) Order by the stock column
 * @method InventarioQuery orderByPrecioUnitario($order = Criteria::ASC) Order by the precio_unitario column
 * @method InventarioQuery orderByNeto($order = Criteria::ASC) Order by the neto column
 * @method InventarioQuery orderByTotal($order = Criteria::ASC) Order by the total column
 *
 * @method InventarioQuery groupById() Group by the id column
 * @method InventarioQuery groupByProductoId() Group by the producto_id column
 * @method InventarioQuery groupByProveedorId() Group by the proveedor_id column
 * @method InventarioQuery groupByFecha() Group by the fecha column
 * @method InventarioQuery groupByStock() Group by the stock column
 * @method InventarioQuery groupByPrecioUnitario() Group by the precio_unitario column
 * @method InventarioQuery groupByNeto() Group by the neto column
 * @method InventarioQuery groupByTotal() Group by the total column
 *
 * @method InventarioQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method InventarioQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method InventarioQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method InventarioQuery leftJoinProducto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Producto relation
 * @method InventarioQuery rightJoinProducto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Producto relation
 * @method InventarioQuery innerJoinProducto($relationAlias = null) Adds a INNER JOIN clause to the query using the Producto relation
 *
 * @method InventarioQuery leftJoinProveedor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Proveedor relation
 * @method InventarioQuery rightJoinProveedor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Proveedor relation
 * @method InventarioQuery innerJoinProveedor($relationAlias = null) Adds a INNER JOIN clause to the query using the Proveedor relation
 *
 * @method InventarioQuery leftJoinCompras($relationAlias = null) Adds a LEFT JOIN clause to the query using the Compras relation
 * @method InventarioQuery rightJoinCompras($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Compras relation
 * @method InventarioQuery innerJoinCompras($relationAlias = null) Adds a INNER JOIN clause to the query using the Compras relation
 *
 * @method InventarioQuery leftJoinVentas($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ventas relation
 * @method InventarioQuery rightJoinVentas($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ventas relation
 * @method InventarioQuery innerJoinVentas($relationAlias = null) Adds a INNER JOIN clause to the query using the Ventas relation
 *
 * @method Inventario findOne(PropelPDO $con = null) Return the first Inventario matching the query
 * @method Inventario findOneOrCreate(PropelPDO $con = null) Return the first Inventario matching the query, or a new Inventario object populated from the query conditions when no match is found
 *
 * @method Inventario findOneByProductoId(int $producto_id) Return the first Inventario filtered by the producto_id column
 * @method Inventario findOneByProveedorId(int $proveedor_id) Return the first Inventario filtered by the proveedor_id column
 * @method Inventario findOneByFecha(string $fecha) Return the first Inventario filtered by the fecha column
 * @method Inventario findOneByStock(int $stock) Return the first Inventario filtered by the stock column
 * @method Inventario findOneByPrecioUnitario(string $precio_unitario) Return the first Inventario filtered by the precio_unitario column
 * @method Inventario findOneByNeto(string $neto) Return the first Inventario filtered by the neto column
 * @method Inventario findOneByTotal(string $total) Return the first Inventario filtered by the total column
 *
 * @method array findById(int $id) Return Inventario objects filtered by the id column
 * @method array findByProductoId(int $producto_id) Return Inventario objects filtered by the producto_id column
 * @method array findByProveedorId(int $proveedor_id) Return Inventario objects filtered by the proveedor_id column
 * @method array findByFecha(string $fecha) Return Inventario objects filtered by the fecha column
 * @method array findByStock(int $stock) Return Inventario objects filtered by the stock column
 * @method array findByPrecioUnitario(string $precio_unitario) Return Inventario objects filtered by the precio_unitario column
 * @method array findByNeto(string $neto) Return Inventario objects filtered by the neto column
 * @method array findByTotal(string $total) Return Inventario objects filtered by the total column
 */
abstract class BaseInventarioQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseInventarioQuery object.
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
            $modelName = 'TS\\BodegaBundle\\Model\\Inventario';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new InventarioQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   InventarioQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return InventarioQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof InventarioQuery) {
            return $criteria;
        }
        $query = new InventarioQuery(null, null, $modelAlias);

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
     * @return   Inventario|Inventario[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = InventarioPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(InventarioPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Inventario A model object, or null if the key is not found
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
     * @return                 Inventario A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `producto_id`, `proveedor_id`, `fecha`, `stock`, `precio_unitario`, `neto`, `total` FROM `inventario` WHERE `id` = :p0';
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
            $obj = new Inventario();
            $obj->hydrate($row);
            InventarioPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Inventario|Inventario[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Inventario[]|mixed the list of results, formatted by the current formatter
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
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InventarioPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InventarioPeer::ID, $keys, Criteria::IN);
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
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(InventarioPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(InventarioPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventarioPeer::ID, $id, $comparison);
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
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterByProductoId($productoId = null, $comparison = null)
    {
        if (is_array($productoId)) {
            $useMinMax = false;
            if (isset($productoId['min'])) {
                $this->addUsingAlias(InventarioPeer::PRODUCTO_ID, $productoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productoId['max'])) {
                $this->addUsingAlias(InventarioPeer::PRODUCTO_ID, $productoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventarioPeer::PRODUCTO_ID, $productoId, $comparison);
    }

    /**
     * Filter the query on the proveedor_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProveedorId(1234); // WHERE proveedor_id = 1234
     * $query->filterByProveedorId(array(12, 34)); // WHERE proveedor_id IN (12, 34)
     * $query->filterByProveedorId(array('min' => 12)); // WHERE proveedor_id >= 12
     * $query->filterByProveedorId(array('max' => 12)); // WHERE proveedor_id <= 12
     * </code>
     *
     * @see       filterByProveedor()
     *
     * @param     mixed $proveedorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterByProveedorId($proveedorId = null, $comparison = null)
    {
        if (is_array($proveedorId)) {
            $useMinMax = false;
            if (isset($proveedorId['min'])) {
                $this->addUsingAlias(InventarioPeer::PROVEEDOR_ID, $proveedorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($proveedorId['max'])) {
                $this->addUsingAlias(InventarioPeer::PROVEEDOR_ID, $proveedorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventarioPeer::PROVEEDOR_ID, $proveedorId, $comparison);
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
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterByFecha($fecha = null, $comparison = null)
    {
        if (is_array($fecha)) {
            $useMinMax = false;
            if (isset($fecha['min'])) {
                $this->addUsingAlias(InventarioPeer::FECHA, $fecha['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fecha['max'])) {
                $this->addUsingAlias(InventarioPeer::FECHA, $fecha['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventarioPeer::FECHA, $fecha, $comparison);
    }

    /**
     * Filter the query on the stock column
     *
     * Example usage:
     * <code>
     * $query->filterByStock(1234); // WHERE stock = 1234
     * $query->filterByStock(array(12, 34)); // WHERE stock IN (12, 34)
     * $query->filterByStock(array('min' => 12)); // WHERE stock >= 12
     * $query->filterByStock(array('max' => 12)); // WHERE stock <= 12
     * </code>
     *
     * @param     mixed $stock The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterByStock($stock = null, $comparison = null)
    {
        if (is_array($stock)) {
            $useMinMax = false;
            if (isset($stock['min'])) {
                $this->addUsingAlias(InventarioPeer::STOCK, $stock['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stock['max'])) {
                $this->addUsingAlias(InventarioPeer::STOCK, $stock['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventarioPeer::STOCK, $stock, $comparison);
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
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterByPrecioUnitario($precioUnitario = null, $comparison = null)
    {
        if (is_array($precioUnitario)) {
            $useMinMax = false;
            if (isset($precioUnitario['min'])) {
                $this->addUsingAlias(InventarioPeer::PRECIO_UNITARIO, $precioUnitario['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($precioUnitario['max'])) {
                $this->addUsingAlias(InventarioPeer::PRECIO_UNITARIO, $precioUnitario['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventarioPeer::PRECIO_UNITARIO, $precioUnitario, $comparison);
    }

    /**
     * Filter the query on the neto column
     *
     * Example usage:
     * <code>
     * $query->filterByNeto(1234); // WHERE neto = 1234
     * $query->filterByNeto(array(12, 34)); // WHERE neto IN (12, 34)
     * $query->filterByNeto(array('min' => 12)); // WHERE neto >= 12
     * $query->filterByNeto(array('max' => 12)); // WHERE neto <= 12
     * </code>
     *
     * @param     mixed $neto The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterByNeto($neto = null, $comparison = null)
    {
        if (is_array($neto)) {
            $useMinMax = false;
            if (isset($neto['min'])) {
                $this->addUsingAlias(InventarioPeer::NETO, $neto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($neto['max'])) {
                $this->addUsingAlias(InventarioPeer::NETO, $neto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventarioPeer::NETO, $neto, $comparison);
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
     * @return InventarioQuery The current query, for fluid interface
     */
    public function filterByTotal($total = null, $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(InventarioPeer::TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(InventarioPeer::TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventarioPeer::TOTAL, $total, $comparison);
    }

    /**
     * Filter the query by a related Producto object
     *
     * @param   Producto|PropelObjectCollection $producto The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 InventarioQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProducto($producto, $comparison = null)
    {
        if ($producto instanceof Producto) {
            return $this
                ->addUsingAlias(InventarioPeer::PRODUCTO_ID, $producto->getId(), $comparison);
        } elseif ($producto instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventarioPeer::PRODUCTO_ID, $producto->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return InventarioQuery The current query, for fluid interface
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
     * Filter the query by a related Proveedor object
     *
     * @param   Proveedor|PropelObjectCollection $proveedor The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 InventarioQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProveedor($proveedor, $comparison = null)
    {
        if ($proveedor instanceof Proveedor) {
            return $this
                ->addUsingAlias(InventarioPeer::PROVEEDOR_ID, $proveedor->getId(), $comparison);
        } elseif ($proveedor instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventarioPeer::PROVEEDOR_ID, $proveedor->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProveedor() only accepts arguments of type Proveedor or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Proveedor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return InventarioQuery The current query, for fluid interface
     */
    public function joinProveedor($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Proveedor');

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
            $this->addJoinObject($join, 'Proveedor');
        }

        return $this;
    }

    /**
     * Use the Proveedor relation Proveedor object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TS\BodegaBundle\Model\ProveedorQuery A secondary query class using the current class as primary query
     */
    public function useProveedorQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProveedor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Proveedor', '\TS\BodegaBundle\Model\ProveedorQuery');
    }

    /**
     * Filter the query by a related Compras object
     *
     * @param   Compras|PropelObjectCollection $compras  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 InventarioQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCompras($compras, $comparison = null)
    {
        if ($compras instanceof Compras) {
            return $this
                ->addUsingAlias(InventarioPeer::ID, $compras->getInventarioId(), $comparison);
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
     * @return InventarioQuery The current query, for fluid interface
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
     * @return                 InventarioQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByVentas($ventas, $comparison = null)
    {
        if ($ventas instanceof Ventas) {
            return $this
                ->addUsingAlias(InventarioPeer::ID, $ventas->getInventarioId(), $comparison);
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
     * @return InventarioQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Inventario $inventario Object to remove from the list of results
     *
     * @return InventarioQuery The current query, for fluid interface
     */
    public function prune($inventario = null)
    {
        if ($inventario) {
            $this->addUsingAlias(InventarioPeer::ID, $inventario->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
