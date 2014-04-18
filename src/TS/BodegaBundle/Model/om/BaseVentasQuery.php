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
use TS\BodegaBundle\Model\Factura;
use TS\BodegaBundle\Model\Inventario;
use TS\BodegaBundle\Model\Ventas;
use TS\BodegaBundle\Model\VentasPeer;
use TS\BodegaBundle\Model\VentasQuery;

/**
 * @method VentasQuery orderById($order = Criteria::ASC) Order by the id column
 * @method VentasQuery orderByInventarioId($order = Criteria::ASC) Order by the inventario_id column
 * @method VentasQuery orderByFacturaId($order = Criteria::ASC) Order by the factura_id column
 * @method VentasQuery orderByClientesId($order = Criteria::ASC) Order by the clientes_id column
 *
 * @method VentasQuery groupById() Group by the id column
 * @method VentasQuery groupByInventarioId() Group by the inventario_id column
 * @method VentasQuery groupByFacturaId() Group by the factura_id column
 * @method VentasQuery groupByClientesId() Group by the clientes_id column
 *
 * @method VentasQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method VentasQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method VentasQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method VentasQuery leftJoinClientes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Clientes relation
 * @method VentasQuery rightJoinClientes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Clientes relation
 * @method VentasQuery innerJoinClientes($relationAlias = null) Adds a INNER JOIN clause to the query using the Clientes relation
 *
 * @method VentasQuery leftJoinFactura($relationAlias = null) Adds a LEFT JOIN clause to the query using the Factura relation
 * @method VentasQuery rightJoinFactura($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Factura relation
 * @method VentasQuery innerJoinFactura($relationAlias = null) Adds a INNER JOIN clause to the query using the Factura relation
 *
 * @method VentasQuery leftJoinInventario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inventario relation
 * @method VentasQuery rightJoinInventario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inventario relation
 * @method VentasQuery innerJoinInventario($relationAlias = null) Adds a INNER JOIN clause to the query using the Inventario relation
 *
 * @method Ventas findOne(PropelPDO $con = null) Return the first Ventas matching the query
 * @method Ventas findOneOrCreate(PropelPDO $con = null) Return the first Ventas matching the query, or a new Ventas object populated from the query conditions when no match is found
 *
 * @method Ventas findOneByInventarioId(int $inventario_id) Return the first Ventas filtered by the inventario_id column
 * @method Ventas findOneByFacturaId(int $factura_id) Return the first Ventas filtered by the factura_id column
 * @method Ventas findOneByClientesId(int $clientes_id) Return the first Ventas filtered by the clientes_id column
 *
 * @method array findById(int $id) Return Ventas objects filtered by the id column
 * @method array findByInventarioId(int $inventario_id) Return Ventas objects filtered by the inventario_id column
 * @method array findByFacturaId(int $factura_id) Return Ventas objects filtered by the factura_id column
 * @method array findByClientesId(int $clientes_id) Return Ventas objects filtered by the clientes_id column
 */
abstract class BaseVentasQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseVentasQuery object.
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
            $modelName = 'TS\\BodegaBundle\\Model\\Ventas';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new VentasQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   VentasQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return VentasQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof VentasQuery) {
            return $criteria;
        }
        $query = new VentasQuery(null, null, $modelAlias);

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
     * @return   Ventas|Ventas[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = VentasPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(VentasPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Ventas A model object, or null if the key is not found
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
     * @return                 Ventas A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `inventario_id`, `factura_id`, `clientes_id` FROM `ventas` WHERE `id` = :p0';
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
            $obj = new Ventas();
            $obj->hydrate($row);
            VentasPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Ventas|Ventas[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Ventas[]|mixed the list of results, formatted by the current formatter
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
     * @return VentasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VentasPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return VentasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VentasPeer::ID, $keys, Criteria::IN);
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
     * @return VentasQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VentasPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VentasPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VentasPeer::ID, $id, $comparison);
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
     * @return VentasQuery The current query, for fluid interface
     */
    public function filterByInventarioId($inventarioId = null, $comparison = null)
    {
        if (is_array($inventarioId)) {
            $useMinMax = false;
            if (isset($inventarioId['min'])) {
                $this->addUsingAlias(VentasPeer::INVENTARIO_ID, $inventarioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inventarioId['max'])) {
                $this->addUsingAlias(VentasPeer::INVENTARIO_ID, $inventarioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VentasPeer::INVENTARIO_ID, $inventarioId, $comparison);
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
     * @return VentasQuery The current query, for fluid interface
     */
    public function filterByFacturaId($facturaId = null, $comparison = null)
    {
        if (is_array($facturaId)) {
            $useMinMax = false;
            if (isset($facturaId['min'])) {
                $this->addUsingAlias(VentasPeer::FACTURA_ID, $facturaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($facturaId['max'])) {
                $this->addUsingAlias(VentasPeer::FACTURA_ID, $facturaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VentasPeer::FACTURA_ID, $facturaId, $comparison);
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
     * @return VentasQuery The current query, for fluid interface
     */
    public function filterByClientesId($clientesId = null, $comparison = null)
    {
        if (is_array($clientesId)) {
            $useMinMax = false;
            if (isset($clientesId['min'])) {
                $this->addUsingAlias(VentasPeer::CLIENTES_ID, $clientesId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clientesId['max'])) {
                $this->addUsingAlias(VentasPeer::CLIENTES_ID, $clientesId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VentasPeer::CLIENTES_ID, $clientesId, $comparison);
    }

    /**
     * Filter the query by a related Clientes object
     *
     * @param   Clientes|PropelObjectCollection $clientes The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 VentasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByClientes($clientes, $comparison = null)
    {
        if ($clientes instanceof Clientes) {
            return $this
                ->addUsingAlias(VentasPeer::CLIENTES_ID, $clientes->getId(), $comparison);
        } elseif ($clientes instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VentasPeer::CLIENTES_ID, $clientes->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return VentasQuery The current query, for fluid interface
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
     * Filter the query by a related Factura object
     *
     * @param   Factura|PropelObjectCollection $factura The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 VentasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFactura($factura, $comparison = null)
    {
        if ($factura instanceof Factura) {
            return $this
                ->addUsingAlias(VentasPeer::FACTURA_ID, $factura->getId(), $comparison);
        } elseif ($factura instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VentasPeer::FACTURA_ID, $factura->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return VentasQuery The current query, for fluid interface
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
     * @return                 VentasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByInventario($inventario, $comparison = null)
    {
        if ($inventario instanceof Inventario) {
            return $this
                ->addUsingAlias(VentasPeer::INVENTARIO_ID, $inventario->getId(), $comparison);
        } elseif ($inventario instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VentasPeer::INVENTARIO_ID, $inventario->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return VentasQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Ventas $ventas Object to remove from the list of results
     *
     * @return VentasQuery The current query, for fluid interface
     */
    public function prune($ventas = null)
    {
        if ($ventas) {
            $this->addUsingAlias(VentasPeer::ID, $ventas->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
