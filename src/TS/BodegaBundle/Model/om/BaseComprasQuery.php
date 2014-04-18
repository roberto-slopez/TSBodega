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
use TS\BodegaBundle\Model\ComprasPeer;
use TS\BodegaBundle\Model\ComprasQuery;
use TS\BodegaBundle\Model\Factura;
use TS\BodegaBundle\Model\Inventario;
use TS\BodegaBundle\Model\Producto;
use TS\BodegaBundle\Model\Proveedor;

/**
 * @method ComprasQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ComprasQuery orderByProveedorId($order = Criteria::ASC) Order by the proveedor_id column
 * @method ComprasQuery orderByInventarioId($order = Criteria::ASC) Order by the inventario_id column
 * @method ComprasQuery orderByFacturaId($order = Criteria::ASC) Order by the factura_id column
 * @method ComprasQuery orderByProductoId($order = Criteria::ASC) Order by the producto_id column
 *
 * @method ComprasQuery groupById() Group by the id column
 * @method ComprasQuery groupByProveedorId() Group by the proveedor_id column
 * @method ComprasQuery groupByInventarioId() Group by the inventario_id column
 * @method ComprasQuery groupByFacturaId() Group by the factura_id column
 * @method ComprasQuery groupByProductoId() Group by the producto_id column
 *
 * @method ComprasQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ComprasQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ComprasQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ComprasQuery leftJoinProveedor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Proveedor relation
 * @method ComprasQuery rightJoinProveedor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Proveedor relation
 * @method ComprasQuery innerJoinProveedor($relationAlias = null) Adds a INNER JOIN clause to the query using the Proveedor relation
 *
 * @method ComprasQuery leftJoinFactura($relationAlias = null) Adds a LEFT JOIN clause to the query using the Factura relation
 * @method ComprasQuery rightJoinFactura($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Factura relation
 * @method ComprasQuery innerJoinFactura($relationAlias = null) Adds a INNER JOIN clause to the query using the Factura relation
 *
 * @method ComprasQuery leftJoinInventario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inventario relation
 * @method ComprasQuery rightJoinInventario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inventario relation
 * @method ComprasQuery innerJoinInventario($relationAlias = null) Adds a INNER JOIN clause to the query using the Inventario relation
 *
 * @method ComprasQuery leftJoinProducto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Producto relation
 * @method ComprasQuery rightJoinProducto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Producto relation
 * @method ComprasQuery innerJoinProducto($relationAlias = null) Adds a INNER JOIN clause to the query using the Producto relation
 *
 * @method Compras findOne(PropelPDO $con = null) Return the first Compras matching the query
 * @method Compras findOneOrCreate(PropelPDO $con = null) Return the first Compras matching the query, or a new Compras object populated from the query conditions when no match is found
 *
 * @method Compras findOneByProveedorId(int $proveedor_id) Return the first Compras filtered by the proveedor_id column
 * @method Compras findOneByInventarioId(int $inventario_id) Return the first Compras filtered by the inventario_id column
 * @method Compras findOneByFacturaId(int $factura_id) Return the first Compras filtered by the factura_id column
 * @method Compras findOneByProductoId(int $producto_id) Return the first Compras filtered by the producto_id column
 *
 * @method array findById(int $id) Return Compras objects filtered by the id column
 * @method array findByProveedorId(int $proveedor_id) Return Compras objects filtered by the proveedor_id column
 * @method array findByInventarioId(int $inventario_id) Return Compras objects filtered by the inventario_id column
 * @method array findByFacturaId(int $factura_id) Return Compras objects filtered by the factura_id column
 * @method array findByProductoId(int $producto_id) Return Compras objects filtered by the producto_id column
 */
abstract class BaseComprasQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseComprasQuery object.
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
            $modelName = 'TS\\BodegaBundle\\Model\\Compras';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ComprasQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ComprasQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ComprasQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ComprasQuery) {
            return $criteria;
        }
        $query = new ComprasQuery(null, null, $modelAlias);

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
     * @return   Compras|Compras[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ComprasPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ComprasPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Compras A model object, or null if the key is not found
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
     * @return                 Compras A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `proveedor_id`, `inventario_id`, `factura_id`, `producto_id` FROM `compras` WHERE `id` = :p0';
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
            $obj = new Compras();
            $obj->hydrate($row);
            ComprasPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Compras|Compras[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Compras[]|mixed the list of results, formatted by the current formatter
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
     * @return ComprasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ComprasPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ComprasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ComprasPeer::ID, $keys, Criteria::IN);
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
     * @return ComprasQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ComprasPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ComprasPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComprasPeer::ID, $id, $comparison);
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
     * @return ComprasQuery The current query, for fluid interface
     */
    public function filterByProveedorId($proveedorId = null, $comparison = null)
    {
        if (is_array($proveedorId)) {
            $useMinMax = false;
            if (isset($proveedorId['min'])) {
                $this->addUsingAlias(ComprasPeer::PROVEEDOR_ID, $proveedorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($proveedorId['max'])) {
                $this->addUsingAlias(ComprasPeer::PROVEEDOR_ID, $proveedorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComprasPeer::PROVEEDOR_ID, $proveedorId, $comparison);
    }

    /**
     * Filter the query on the inventario_id column
     *
     * Example usage:
     * <code>
     * $query->filterByInventarioId(1234); // WHERE inventario_id = 1234
     * $query->filterByInventarioId(array(12, 34)); // WHERE inventario_id IN (12, 34)
     * $query->filterByInventarioId(array('min' => 12)); // WHERE inventario_id >= 12
     * $query->filterByInventarioId(array('max' => 12)); // WHERE inventario_id <= 12
     * </code>
     *
     * @see       filterByInventario()
     *
     * @param     mixed $inventarioId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ComprasQuery The current query, for fluid interface
     */
    public function filterByInventarioId($inventarioId = null, $comparison = null)
    {
        if (is_array($inventarioId)) {
            $useMinMax = false;
            if (isset($inventarioId['min'])) {
                $this->addUsingAlias(ComprasPeer::INVENTARIO_ID, $inventarioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inventarioId['max'])) {
                $this->addUsingAlias(ComprasPeer::INVENTARIO_ID, $inventarioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComprasPeer::INVENTARIO_ID, $inventarioId, $comparison);
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
     * @return ComprasQuery The current query, for fluid interface
     */
    public function filterByFacturaId($facturaId = null, $comparison = null)
    {
        if (is_array($facturaId)) {
            $useMinMax = false;
            if (isset($facturaId['min'])) {
                $this->addUsingAlias(ComprasPeer::FACTURA_ID, $facturaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($facturaId['max'])) {
                $this->addUsingAlias(ComprasPeer::FACTURA_ID, $facturaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComprasPeer::FACTURA_ID, $facturaId, $comparison);
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
     * @return ComprasQuery The current query, for fluid interface
     */
    public function filterByProductoId($productoId = null, $comparison = null)
    {
        if (is_array($productoId)) {
            $useMinMax = false;
            if (isset($productoId['min'])) {
                $this->addUsingAlias(ComprasPeer::PRODUCTO_ID, $productoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productoId['max'])) {
                $this->addUsingAlias(ComprasPeer::PRODUCTO_ID, $productoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComprasPeer::PRODUCTO_ID, $productoId, $comparison);
    }

    /**
     * Filter the query by a related Proveedor object
     *
     * @param   Proveedor|PropelObjectCollection $proveedor The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ComprasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProveedor($proveedor, $comparison = null)
    {
        if ($proveedor instanceof Proveedor) {
            return $this
                ->addUsingAlias(ComprasPeer::PROVEEDOR_ID, $proveedor->getId(), $comparison);
        } elseif ($proveedor instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ComprasPeer::PROVEEDOR_ID, $proveedor->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ComprasQuery The current query, for fluid interface
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
     * Filter the query by a related Factura object
     *
     * @param   Factura|PropelObjectCollection $factura The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ComprasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFactura($factura, $comparison = null)
    {
        if ($factura instanceof Factura) {
            return $this
                ->addUsingAlias(ComprasPeer::FACTURA_ID, $factura->getId(), $comparison);
        } elseif ($factura instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ComprasPeer::FACTURA_ID, $factura->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ComprasQuery The current query, for fluid interface
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
     * Filter the query by a related Inventario object
     *
     * @param   Inventario|PropelObjectCollection $inventario The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ComprasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByInventario($inventario, $comparison = null)
    {
        if ($inventario instanceof Inventario) {
            return $this
                ->addUsingAlias(ComprasPeer::INVENTARIO_ID, $inventario->getId(), $comparison);
        } elseif ($inventario instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ComprasPeer::INVENTARIO_ID, $inventario->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByInventario() only accepts arguments of type Inventario or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Inventario relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ComprasQuery The current query, for fluid interface
     */
    public function joinInventario($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Inventario');

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
            $this->addJoinObject($join, 'Inventario');
        }

        return $this;
    }

    /**
     * Use the Inventario relation Inventario object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TS\BodegaBundle\Model\InventarioQuery A secondary query class using the current class as primary query
     */
    public function useInventarioQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinInventario($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Inventario', '\TS\BodegaBundle\Model\InventarioQuery');
    }

    /**
     * Filter the query by a related Producto object
     *
     * @param   Producto|PropelObjectCollection $producto The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ComprasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProducto($producto, $comparison = null)
    {
        if ($producto instanceof Producto) {
            return $this
                ->addUsingAlias(ComprasPeer::PRODUCTO_ID, $producto->getId(), $comparison);
        } elseif ($producto instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ComprasPeer::PRODUCTO_ID, $producto->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ComprasQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Compras $compras Object to remove from the list of results
     *
     * @return ComprasQuery The current query, for fluid interface
     */
    public function prune($compras = null)
    {
        if ($compras) {
            $this->addUsingAlias(ComprasPeer::ID, $compras->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
