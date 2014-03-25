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
use TS\BodegaBundle\Model\Categoria;
use TS\BodegaBundle\Model\Producto;
use TS\BodegaBundle\Model\ProductoPeer;
use TS\BodegaBundle\Model\ProductoQuery;

/**
 * @method ProductoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProductoQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method ProductoQuery orderByPrecio($order = Criteria::ASC) Order by the precio column
 * @method ProductoQuery orderByDescripcion($order = Criteria::ASC) Order by the descripcion column
 * @method ProductoQuery orderByCategoriaId($order = Criteria::ASC) Order by the categoria_id column
 *
 * @method ProductoQuery groupById() Group by the id column
 * @method ProductoQuery groupByNombre() Group by the nombre column
 * @method ProductoQuery groupByPrecio() Group by the precio column
 * @method ProductoQuery groupByDescripcion() Group by the descripcion column
 * @method ProductoQuery groupByCategoriaId() Group by the categoria_id column
 *
 * @method ProductoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProductoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProductoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProductoQuery leftJoinCategoria($relationAlias = null) Adds a LEFT JOIN clause to the query using the Categoria relation
 * @method ProductoQuery rightJoinCategoria($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Categoria relation
 * @method ProductoQuery innerJoinCategoria($relationAlias = null) Adds a INNER JOIN clause to the query using the Categoria relation
 *
 * @method Producto findOne(PropelPDO $con = null) Return the first Producto matching the query
 * @method Producto findOneOrCreate(PropelPDO $con = null) Return the first Producto matching the query, or a new Producto object populated from the query conditions when no match is found
 *
 * @method Producto findOneByNombre(string $nombre) Return the first Producto filtered by the nombre column
 * @method Producto findOneByPrecio(string $precio) Return the first Producto filtered by the precio column
 * @method Producto findOneByDescripcion(string $descripcion) Return the first Producto filtered by the descripcion column
 * @method Producto findOneByCategoriaId(int $categoria_id) Return the first Producto filtered by the categoria_id column
 *
 * @method array findById(int $id) Return Producto objects filtered by the id column
 * @method array findByNombre(string $nombre) Return Producto objects filtered by the nombre column
 * @method array findByPrecio(string $precio) Return Producto objects filtered by the precio column
 * @method array findByDescripcion(string $descripcion) Return Producto objects filtered by the descripcion column
 * @method array findByCategoriaId(int $categoria_id) Return Producto objects filtered by the categoria_id column
 */
abstract class BaseProductoQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProductoQuery object.
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
            $modelName = 'TS\\BodegaBundle\\Model\\Producto';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProductoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProductoQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProductoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProductoQuery) {
            return $criteria;
        }
        $query = new ProductoQuery(null, null, $modelAlias);

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
     * @return   Producto|Producto[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductoPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProductoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Producto A model object, or null if the key is not found
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
     * @return                 Producto A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `nombre`, `precio`, `descripcion`, `categoria_id` FROM `producto` WHERE `id` = :p0';
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
            $obj = new Producto();
            $obj->hydrate($row);
            ProductoPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Producto|Producto[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Producto[]|mixed the list of results, formatted by the current formatter
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
     * @return ProductoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductoPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProductoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductoPeer::ID, $keys, Criteria::IN);
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
     * @return ProductoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProductoPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductoPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductoPeer::ID, $id, $comparison);
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
     * @return ProductoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProductoPeer::NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the precio column
     *
     * Example usage:
     * <code>
     * $query->filterByPrecio(1234); // WHERE precio = 1234
     * $query->filterByPrecio(array(12, 34)); // WHERE precio IN (12, 34)
     * $query->filterByPrecio(array('min' => 12)); // WHERE precio >= 12
     * $query->filterByPrecio(array('max' => 12)); // WHERE precio <= 12
     * </code>
     *
     * @param     mixed $precio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductoQuery The current query, for fluid interface
     */
    public function filterByPrecio($precio = null, $comparison = null)
    {
        if (is_array($precio)) {
            $useMinMax = false;
            if (isset($precio['min'])) {
                $this->addUsingAlias(ProductoPeer::PRECIO, $precio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($precio['max'])) {
                $this->addUsingAlias(ProductoPeer::PRECIO, $precio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductoPeer::PRECIO, $precio, $comparison);
    }

    /**
     * Filter the query on the descripcion column
     *
     * Example usage:
     * <code>
     * $query->filterByDescripcion('fooValue');   // WHERE descripcion = 'fooValue'
     * $query->filterByDescripcion('%fooValue%'); // WHERE descripcion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descripcion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductoQuery The current query, for fluid interface
     */
    public function filterByDescripcion($descripcion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descripcion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $descripcion)) {
                $descripcion = str_replace('*', '%', $descripcion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductoPeer::DESCRIPCION, $descripcion, $comparison);
    }

    /**
     * Filter the query on the categoria_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoriaId(1234); // WHERE categoria_id = 1234
     * $query->filterByCategoriaId(array(12, 34)); // WHERE categoria_id IN (12, 34)
     * $query->filterByCategoriaId(array('min' => 12)); // WHERE categoria_id >= 12
     * $query->filterByCategoriaId(array('max' => 12)); // WHERE categoria_id <= 12
     * </code>
     *
     * @see       filterByCategoria()
     *
     * @param     mixed $categoriaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductoQuery The current query, for fluid interface
     */
    public function filterByCategoriaId($categoriaId = null, $comparison = null)
    {
        if (is_array($categoriaId)) {
            $useMinMax = false;
            if (isset($categoriaId['min'])) {
                $this->addUsingAlias(ProductoPeer::CATEGORIA_ID, $categoriaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoriaId['max'])) {
                $this->addUsingAlias(ProductoPeer::CATEGORIA_ID, $categoriaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductoPeer::CATEGORIA_ID, $categoriaId, $comparison);
    }

    /**
     * Filter the query by a related Categoria object
     *
     * @param   Categoria|PropelObjectCollection $categoria The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProductoQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCategoria($categoria, $comparison = null)
    {
        if ($categoria instanceof Categoria) {
            return $this
                ->addUsingAlias(ProductoPeer::CATEGORIA_ID, $categoria->getId(), $comparison);
        } elseif ($categoria instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductoPeer::CATEGORIA_ID, $categoria->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategoria() only accepts arguments of type Categoria or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Categoria relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProductoQuery The current query, for fluid interface
     */
    public function joinCategoria($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Categoria');

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
            $this->addJoinObject($join, 'Categoria');
        }

        return $this;
    }

    /**
     * Use the Categoria relation Categoria object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TS\BodegaBundle\Model\CategoriaQuery A secondary query class using the current class as primary query
     */
    public function useCategoriaQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCategoria($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Categoria', '\TS\BodegaBundle\Model\CategoriaQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Producto $producto Object to remove from the list of results
     *
     * @return ProductoQuery The current query, for fluid interface
     */
    public function prune($producto = null)
    {
        if ($producto) {
            $this->addUsingAlias(ProductoPeer::ID, $producto->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
