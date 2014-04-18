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
use TS\BodegaBundle\Model\ClientesPeer;
use TS\BodegaBundle\Model\ClientesQuery;
use TS\BodegaBundle\Model\Factura;
use TS\BodegaBundle\Model\Ventas;

/**
 * @method ClientesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ClientesQuery orderByNombres($order = Criteria::ASC) Order by the nombres column
 * @method ClientesQuery orderByApellidos($order = Criteria::ASC) Order by the apellidos column
 * @method ClientesQuery orderByNombreCompleto($order = Criteria::ASC) Order by the nombre_completo column
 * @method ClientesQuery orderByDpi($order = Criteria::ASC) Order by the dpi column
 * @method ClientesQuery orderByNit($order = Criteria::ASC) Order by the nit column
 * @method ClientesQuery orderByTelefono($order = Criteria::ASC) Order by the telefono column
 * @method ClientesQuery orderByDireccion($order = Criteria::ASC) Order by the direccion column
 *
 * @method ClientesQuery groupById() Group by the id column
 * @method ClientesQuery groupByNombres() Group by the nombres column
 * @method ClientesQuery groupByApellidos() Group by the apellidos column
 * @method ClientesQuery groupByNombreCompleto() Group by the nombre_completo column
 * @method ClientesQuery groupByDpi() Group by the dpi column
 * @method ClientesQuery groupByNit() Group by the nit column
 * @method ClientesQuery groupByTelefono() Group by the telefono column
 * @method ClientesQuery groupByDireccion() Group by the direccion column
 *
 * @method ClientesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ClientesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ClientesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ClientesQuery leftJoinVentas($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ventas relation
 * @method ClientesQuery rightJoinVentas($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ventas relation
 * @method ClientesQuery innerJoinVentas($relationAlias = null) Adds a INNER JOIN clause to the query using the Ventas relation
 *
 * @method ClientesQuery leftJoinFactura($relationAlias = null) Adds a LEFT JOIN clause to the query using the Factura relation
 * @method ClientesQuery rightJoinFactura($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Factura relation
 * @method ClientesQuery innerJoinFactura($relationAlias = null) Adds a INNER JOIN clause to the query using the Factura relation
 *
 * @method Clientes findOne(PropelPDO $con = null) Return the first Clientes matching the query
 * @method Clientes findOneOrCreate(PropelPDO $con = null) Return the first Clientes matching the query, or a new Clientes object populated from the query conditions when no match is found
 *
 * @method Clientes findOneByNombres(string $nombres) Return the first Clientes filtered by the nombres column
 * @method Clientes findOneByApellidos(string $apellidos) Return the first Clientes filtered by the apellidos column
 * @method Clientes findOneByNombreCompleto(string $nombre_completo) Return the first Clientes filtered by the nombre_completo column
 * @method Clientes findOneByDpi(string $dpi) Return the first Clientes filtered by the dpi column
 * @method Clientes findOneByNit(string $nit) Return the first Clientes filtered by the nit column
 * @method Clientes findOneByTelefono(string $telefono) Return the first Clientes filtered by the telefono column
 * @method Clientes findOneByDireccion(string $direccion) Return the first Clientes filtered by the direccion column
 *
 * @method array findById(int $id) Return Clientes objects filtered by the id column
 * @method array findByNombres(string $nombres) Return Clientes objects filtered by the nombres column
 * @method array findByApellidos(string $apellidos) Return Clientes objects filtered by the apellidos column
 * @method array findByNombreCompleto(string $nombre_completo) Return Clientes objects filtered by the nombre_completo column
 * @method array findByDpi(string $dpi) Return Clientes objects filtered by the dpi column
 * @method array findByNit(string $nit) Return Clientes objects filtered by the nit column
 * @method array findByTelefono(string $telefono) Return Clientes objects filtered by the telefono column
 * @method array findByDireccion(string $direccion) Return Clientes objects filtered by the direccion column
 */
abstract class BaseClientesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseClientesQuery object.
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
            $modelName = 'TS\\BodegaBundle\\Model\\Clientes';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ClientesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ClientesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ClientesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ClientesQuery) {
            return $criteria;
        }
        $query = new ClientesQuery(null, null, $modelAlias);

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
     * @return   Clientes|Clientes[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ClientesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ClientesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Clientes A model object, or null if the key is not found
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
     * @return                 Clientes A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `nombres`, `apellidos`, `nombre_completo`, `dpi`, `nit`, `telefono`, `direccion` FROM `clientes` WHERE `id` = :p0';
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
            $obj = new Clientes();
            $obj->hydrate($row);
            ClientesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Clientes|Clientes[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Clientes[]|mixed the list of results, formatted by the current formatter
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
     * @return ClientesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ClientesPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ClientesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ClientesPeer::ID, $keys, Criteria::IN);
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
     * @return ClientesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ClientesPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ClientesPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientesPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the nombres column
     *
     * Example usage:
     * <code>
     * $query->filterByNombres('fooValue');   // WHERE nombres = 'fooValue'
     * $query->filterByNombres('%fooValue%'); // WHERE nombres LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nombres The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ClientesQuery The current query, for fluid interface
     */
    public function filterByNombres($nombres = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nombres)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nombres)) {
                $nombres = str_replace('*', '%', $nombres);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ClientesPeer::NOMBRES, $nombres, $comparison);
    }

    /**
     * Filter the query on the apellidos column
     *
     * Example usage:
     * <code>
     * $query->filterByApellidos('fooValue');   // WHERE apellidos = 'fooValue'
     * $query->filterByApellidos('%fooValue%'); // WHERE apellidos LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apellidos The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ClientesQuery The current query, for fluid interface
     */
    public function filterByApellidos($apellidos = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apellidos)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apellidos)) {
                $apellidos = str_replace('*', '%', $apellidos);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ClientesPeer::APELLIDOS, $apellidos, $comparison);
    }

    /**
     * Filter the query on the nombre_completo column
     *
     * Example usage:
     * <code>
     * $query->filterByNombreCompleto('fooValue');   // WHERE nombre_completo = 'fooValue'
     * $query->filterByNombreCompleto('%fooValue%'); // WHERE nombre_completo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nombreCompleto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ClientesQuery The current query, for fluid interface
     */
    public function filterByNombreCompleto($nombreCompleto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nombreCompleto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nombreCompleto)) {
                $nombreCompleto = str_replace('*', '%', $nombreCompleto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ClientesPeer::NOMBRE_COMPLETO, $nombreCompleto, $comparison);
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
     * @return ClientesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ClientesPeer::DPI, $dpi, $comparison);
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
     * @return ClientesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ClientesPeer::NIT, $nit, $comparison);
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
     * @return ClientesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ClientesPeer::TELEFONO, $telefono, $comparison);
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
     * @return ClientesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ClientesPeer::DIRECCION, $direccion, $comparison);
    }

    /**
     * Filter the query by a related Ventas object
     *
     * @param   Ventas|PropelObjectCollection $ventas  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ClientesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByVentas($ventas, $comparison = null)
    {
        if ($ventas instanceof Ventas) {
            return $this
                ->addUsingAlias(ClientesPeer::ID, $ventas->getClientesId(), $comparison);
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
     * @return ClientesQuery The current query, for fluid interface
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
     * Filter the query by a related Factura object
     *
     * @param   Factura|PropelObjectCollection $factura  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ClientesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFactura($factura, $comparison = null)
    {
        if ($factura instanceof Factura) {
            return $this
                ->addUsingAlias(ClientesPeer::ID, $factura->getClientesId(), $comparison);
        } elseif ($factura instanceof PropelObjectCollection) {
            return $this
                ->useFacturaQuery()
                ->filterByPrimaryKeys($factura->getPrimaryKeys())
                ->endUse();
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
     * @return ClientesQuery The current query, for fluid interface
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
     * @param   Clientes $clientes Object to remove from the list of results
     *
     * @return ClientesQuery The current query, for fluid interface
     */
    public function prune($clientes = null)
    {
        if ($clientes) {
            $this->addUsingAlias(ClientesPeer::ID, $clientes->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
