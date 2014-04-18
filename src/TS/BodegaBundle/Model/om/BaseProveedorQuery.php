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
use TS\BodegaBundle\Model\Proveedor;
use TS\BodegaBundle\Model\ProveedorPeer;
use TS\BodegaBundle\Model\ProveedorQuery;

/**
 * @method ProveedorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProveedorQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method ProveedorQuery orderByEncargado($order = Criteria::ASC) Order by the encargado column
 * @method ProveedorQuery orderByNit($order = Criteria::ASC) Order by the nit column
 * @method ProveedorQuery orderByDpi($order = Criteria::ASC) Order by the dpi column
 * @method ProveedorQuery orderByDireccion($order = Criteria::ASC) Order by the direccion column
 * @method ProveedorQuery orderByTelefono($order = Criteria::ASC) Order by the telefono column
 * @method ProveedorQuery orderByMovil($order = Criteria::ASC) Order by the movil column
 *
 * @method ProveedorQuery groupById() Group by the id column
 * @method ProveedorQuery groupByNombre() Group by the nombre column
 * @method ProveedorQuery groupByEncargado() Group by the encargado column
 * @method ProveedorQuery groupByNit() Group by the nit column
 * @method ProveedorQuery groupByDpi() Group by the dpi column
 * @method ProveedorQuery groupByDireccion() Group by the direccion column
 * @method ProveedorQuery groupByTelefono() Group by the telefono column
 * @method ProveedorQuery groupByMovil() Group by the movil column
 *
 * @method ProveedorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProveedorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProveedorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProveedorQuery leftJoinCompras($relationAlias = null) Adds a LEFT JOIN clause to the query using the Compras relation
 * @method ProveedorQuery rightJoinCompras($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Compras relation
 * @method ProveedorQuery innerJoinCompras($relationAlias = null) Adds a INNER JOIN clause to the query using the Compras relation
 *
 * @method ProveedorQuery leftJoinInventario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inventario relation
 * @method ProveedorQuery rightJoinInventario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inventario relation
 * @method ProveedorQuery innerJoinInventario($relationAlias = null) Adds a INNER JOIN clause to the query using the Inventario relation
 *
 * @method Proveedor findOne(PropelPDO $con = null) Return the first Proveedor matching the query
 * @method Proveedor findOneOrCreate(PropelPDO $con = null) Return the first Proveedor matching the query, or a new Proveedor object populated from the query conditions when no match is found
 *
 * @method Proveedor findOneByNombre(string $nombre) Return the first Proveedor filtered by the nombre column
 * @method Proveedor findOneByEncargado(string $encargado) Return the first Proveedor filtered by the encargado column
 * @method Proveedor findOneByNit(string $nit) Return the first Proveedor filtered by the nit column
 * @method Proveedor findOneByDpi(string $dpi) Return the first Proveedor filtered by the dpi column
 * @method Proveedor findOneByDireccion(string $direccion) Return the first Proveedor filtered by the direccion column
 * @method Proveedor findOneByTelefono(string $telefono) Return the first Proveedor filtered by the telefono column
 * @method Proveedor findOneByMovil(string $movil) Return the first Proveedor filtered by the movil column
 *
 * @method array findById(int $id) Return Proveedor objects filtered by the id column
 * @method array findByNombre(string $nombre) Return Proveedor objects filtered by the nombre column
 * @method array findByEncargado(string $encargado) Return Proveedor objects filtered by the encargado column
 * @method array findByNit(string $nit) Return Proveedor objects filtered by the nit column
 * @method array findByDpi(string $dpi) Return Proveedor objects filtered by the dpi column
 * @method array findByDireccion(string $direccion) Return Proveedor objects filtered by the direccion column
 * @method array findByTelefono(string $telefono) Return Proveedor objects filtered by the telefono column
 * @method array findByMovil(string $movil) Return Proveedor objects filtered by the movil column
 */
abstract class BaseProveedorQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProveedorQuery object.
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
            $modelName = 'TS\\BodegaBundle\\Model\\Proveedor';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProveedorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProveedorQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProveedorQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProveedorQuery) {
            return $criteria;
        }
        $query = new ProveedorQuery(null, null, $modelAlias);

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
     * @return   Proveedor|Proveedor[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProveedorPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProveedorPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Proveedor A model object, or null if the key is not found
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
     * @return                 Proveedor A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `nombre`, `encargado`, `nit`, `dpi`, `direccion`, `telefono`, `movil` FROM `proveedor` WHERE `id` = :p0';
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
            $obj = new Proveedor();
            $obj->hydrate($row);
            ProveedorPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Proveedor|Proveedor[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Proveedor[]|mixed the list of results, formatted by the current formatter
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
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProveedorPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProveedorPeer::ID, $keys, Criteria::IN);
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
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProveedorPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProveedorPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProveedorPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the nombre column
     *
     * Example usage:
     * <code>
     * $query->filterByNombre('fooValue');   // WHERE nombre = 'fooValue'
     * $query->filterByNombre('%fooValue%'); // WHERE nombre LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nombre The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterByNombre($nombre = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nombre)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nombre)) {
                $nombre = str_replace('*', '%', $nombre);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProveedorPeer::NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the encargado column
     *
     * Example usage:
     * <code>
     * $query->filterByEncargado('fooValue');   // WHERE encargado = 'fooValue'
     * $query->filterByEncargado('%fooValue%'); // WHERE encargado LIKE '%fooValue%'
     * </code>
     *
     * @param     string $encargado The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterByEncargado($encargado = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($encargado)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $encargado)) {
                $encargado = str_replace('*', '%', $encargado);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProveedorPeer::ENCARGADO, $encargado, $comparison);
    }

    /**
     * Filter the query on the nit column
     *
     * Example usage:
     * <code>
     * $query->filterByNit('fooValue');   // WHERE nit = 'fooValue'
     * $query->filterByNit('%fooValue%'); // WHERE nit LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nit The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterByNit($nit = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nit)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nit)) {
                $nit = str_replace('*', '%', $nit);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProveedorPeer::NIT, $nit, $comparison);
    }

    /**
     * Filter the query on the dpi column
     *
     * Example usage:
     * <code>
     * $query->filterByDpi('fooValue');   // WHERE dpi = 'fooValue'
     * $query->filterByDpi('%fooValue%'); // WHERE dpi LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dpi The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterByDpi($dpi = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dpi)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dpi)) {
                $dpi = str_replace('*', '%', $dpi);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProveedorPeer::DPI, $dpi, $comparison);
    }

    /**
     * Filter the query on the direccion column
     *
     * Example usage:
     * <code>
     * $query->filterByDireccion('fooValue');   // WHERE direccion = 'fooValue'
     * $query->filterByDireccion('%fooValue%'); // WHERE direccion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $direccion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterByDireccion($direccion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($direccion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $direccion)) {
                $direccion = str_replace('*', '%', $direccion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProveedorPeer::DIRECCION, $direccion, $comparison);
    }

    /**
     * Filter the query on the telefono column
     *
     * Example usage:
     * <code>
     * $query->filterByTelefono('fooValue');   // WHERE telefono = 'fooValue'
     * $query->filterByTelefono('%fooValue%'); // WHERE telefono LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telefono The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterByTelefono($telefono = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telefono)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $telefono)) {
                $telefono = str_replace('*', '%', $telefono);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProveedorPeer::TELEFONO, $telefono, $comparison);
    }

    /**
     * Filter the query on the movil column
     *
     * Example usage:
     * <code>
     * $query->filterByMovil('fooValue');   // WHERE movil = 'fooValue'
     * $query->filterByMovil('%fooValue%'); // WHERE movil LIKE '%fooValue%'
     * </code>
     *
     * @param     string $movil The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function filterByMovil($movil = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($movil)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $movil)) {
                $movil = str_replace('*', '%', $movil);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProveedorPeer::MOVIL, $movil, $comparison);
    }

    /**
     * Filter the query by a related Compras object
     *
     * @param   Compras|PropelObjectCollection $compras  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProveedorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCompras($compras, $comparison = null)
    {
        if ($compras instanceof Compras) {
            return $this
                ->addUsingAlias(ProveedorPeer::ID, $compras->getProveedorId(), $comparison);
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
     * @return ProveedorQuery The current query, for fluid interface
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
     * Filter the query by a related Inventario object
     *
     * @param   Inventario|PropelObjectCollection $inventario  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProveedorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByInventario($inventario, $comparison = null)
    {
        if ($inventario instanceof Inventario) {
            return $this
                ->addUsingAlias(ProveedorPeer::ID, $inventario->getProveedorId(), $comparison);
        } elseif ($inventario instanceof PropelObjectCollection) {
            return $this
                ->useInventarioQuery()
                ->filterByPrimaryKeys($inventario->getPrimaryKeys())
                ->endUse();
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
     * @return ProveedorQuery The current query, for fluid interface
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
     * @param   Proveedor $proveedor Object to remove from the list of results
     *
     * @return ProveedorQuery The current query, for fluid interface
     */
    public function prune($proveedor = null)
    {
        if ($proveedor) {
            $this->addUsingAlias(ProveedorPeer::ID, $proveedor->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
