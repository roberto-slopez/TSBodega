<?php

namespace TS\BodegaBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use TS\BodegaBundle\Model\Compras;
use TS\BodegaBundle\Model\ComprasQuery;
use TS\BodegaBundle\Model\Inventario;
use TS\BodegaBundle\Model\InventarioPeer;
use TS\BodegaBundle\Model\InventarioQuery;
use TS\BodegaBundle\Model\Producto;
use TS\BodegaBundle\Model\ProductoQuery;
use TS\BodegaBundle\Model\Proveedor;
use TS\BodegaBundle\Model\ProveedorQuery;
use TS\BodegaBundle\Model\Ventas;
use TS\BodegaBundle\Model\VentasQuery;

abstract class BaseInventario extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'TS\\BodegaBundle\\Model\\InventarioPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        InventarioPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the producto_id field.
     * @var        int
     */
    protected $producto_id;

    /**
     * The value for the proveedor_id field.
     * @var        int
     */
    protected $proveedor_id;

    /**
     * The value for the fecha field.
     * @var        string
     */
    protected $fecha;

    /**
     * The value for the stock field.
     * @var        int
     */
    protected $stock;

    /**
     * The value for the precio_unitario field.
     * @var        string
     */
    protected $precio_unitario;

    /**
     * The value for the neto field.
     * @var        string
     */
    protected $neto;

    /**
     * The value for the total field.
     * @var        string
     */
    protected $total;

    /**
     * @var        Producto
     */
    protected $aProducto;

    /**
     * @var        Proveedor
     */
    protected $aProveedor;

    /**
     * @var        PropelObjectCollection|Compras[] Collection to store aggregation of Compras objects.
     */
    protected $collComprass;
    protected $collComprassPartial;

    /**
     * @var        PropelObjectCollection|Ventas[] Collection to store aggregation of Ventas objects.
     */
    protected $collVentass;
    protected $collVentassPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $comprassScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $ventassScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [producto_id] column value.
     *
     * @return int
     */
    public function getProductoId()
    {

        return $this->producto_id;
    }

    /**
     * Get the [proveedor_id] column value.
     *
     * @return int
     */
    public function getProveedorId()
    {

        return $this->proveedor_id;
    }

    /**
     * Get the [optionally formatted] temporal [fecha] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFecha($format = null)
    {
        if ($this->fecha === null) {
            return null;
        }

        if ($this->fecha === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->fecha);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->fecha, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [stock] column value.
     *
     * @return int
     */
    public function getStock()
    {

        return $this->stock;
    }

    /**
     * Get the [precio_unitario] column value.
     *
     * @return string
     */
    public function getPrecioUnitario()
    {

        return $this->precio_unitario;
    }

    /**
     * Get the [neto] column value.
     *
     * @return string
     */
    public function getNeto()
    {

        return $this->neto;
    }

    /**
     * Get the [total] column value.
     *
     * @return string
     */
    public function getTotal()
    {

        return $this->total;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Inventario The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = InventarioPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [producto_id] column.
     *
     * @param  int $v new value
     * @return Inventario The current object (for fluent API support)
     */
    public function setProductoId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->producto_id !== $v) {
            $this->producto_id = $v;
            $this->modifiedColumns[] = InventarioPeer::PRODUCTO_ID;
        }

        if ($this->aProducto !== null && $this->aProducto->getId() !== $v) {
            $this->aProducto = null;
        }


        return $this;
    } // setProductoId()

    /**
     * Set the value of [proveedor_id] column.
     *
     * @param  int $v new value
     * @return Inventario The current object (for fluent API support)
     */
    public function setProveedorId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->proveedor_id !== $v) {
            $this->proveedor_id = $v;
            $this->modifiedColumns[] = InventarioPeer::PROVEEDOR_ID;
        }

        if ($this->aProveedor !== null && $this->aProveedor->getId() !== $v) {
            $this->aProveedor = null;
        }


        return $this;
    } // setProveedorId()

    /**
     * Sets the value of [fecha] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Inventario The current object (for fluent API support)
     */
    public function setFecha($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha !== null || $dt !== null) {
            $currentDateAsString = ($this->fecha !== null && $tmpDt = new DateTime($this->fecha)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->fecha = $newDateAsString;
                $this->modifiedColumns[] = InventarioPeer::FECHA;
            }
        } // if either are not null


        return $this;
    } // setFecha()

    /**
     * Set the value of [stock] column.
     *
     * @param  int $v new value
     * @return Inventario The current object (for fluent API support)
     */
    public function setStock($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->stock !== $v) {
            $this->stock = $v;
            $this->modifiedColumns[] = InventarioPeer::STOCK;
        }


        return $this;
    } // setStock()

    /**
     * Set the value of [precio_unitario] column.
     *
     * @param  string $v new value
     * @return Inventario The current object (for fluent API support)
     */
    public function setPrecioUnitario($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->precio_unitario !== $v) {
            $this->precio_unitario = $v;
            $this->modifiedColumns[] = InventarioPeer::PRECIO_UNITARIO;
        }


        return $this;
    } // setPrecioUnitario()

    /**
     * Set the value of [neto] column.
     *
     * @param  string $v new value
     * @return Inventario The current object (for fluent API support)
     */
    public function setNeto($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->neto !== $v) {
            $this->neto = $v;
            $this->modifiedColumns[] = InventarioPeer::NETO;
        }


        return $this;
    } // setNeto()

    /**
     * Set the value of [total] column.
     *
     * @param  string $v new value
     * @return Inventario The current object (for fluent API support)
     */
    public function setTotal($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->total !== $v) {
            $this->total = $v;
            $this->modifiedColumns[] = InventarioPeer::TOTAL;
        }


        return $this;
    } // setTotal()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->producto_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->proveedor_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->fecha = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->stock = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->precio_unitario = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->neto = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->total = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = InventarioPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Inventario object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aProducto !== null && $this->producto_id !== $this->aProducto->getId()) {
            $this->aProducto = null;
        }
        if ($this->aProveedor !== null && $this->proveedor_id !== $this->aProveedor->getId()) {
            $this->aProveedor = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(InventarioPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = InventarioPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProducto = null;
            $this->aProveedor = null;
            $this->collComprass = null;

            $this->collVentass = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(InventarioPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = InventarioQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(InventarioPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                InventarioPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aProducto !== null) {
                if ($this->aProducto->isModified() || $this->aProducto->isNew()) {
                    $affectedRows += $this->aProducto->save($con);
                }
                $this->setProducto($this->aProducto);
            }

            if ($this->aProveedor !== null) {
                if ($this->aProveedor->isModified() || $this->aProveedor->isNew()) {
                    $affectedRows += $this->aProveedor->save($con);
                }
                $this->setProveedor($this->aProveedor);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->comprassScheduledForDeletion !== null) {
                if (!$this->comprassScheduledForDeletion->isEmpty()) {
                    foreach ($this->comprassScheduledForDeletion as $compras) {
                        // need to save related object because we set the relation to null
                        $compras->save($con);
                    }
                    $this->comprassScheduledForDeletion = null;
                }
            }

            if ($this->collComprass !== null) {
                foreach ($this->collComprass as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->ventassScheduledForDeletion !== null) {
                if (!$this->ventassScheduledForDeletion->isEmpty()) {
                    foreach ($this->ventassScheduledForDeletion as $ventas) {
                        // need to save related object because we set the relation to null
                        $ventas->save($con);
                    }
                    $this->ventassScheduledForDeletion = null;
                }
            }

            if ($this->collVentass !== null) {
                foreach ($this->collVentass as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = InventarioPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . InventarioPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(InventarioPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(InventarioPeer::PRODUCTO_ID)) {
            $modifiedColumns[':p' . $index++]  = '`producto_id`';
        }
        if ($this->isColumnModified(InventarioPeer::PROVEEDOR_ID)) {
            $modifiedColumns[':p' . $index++]  = '`proveedor_id`';
        }
        if ($this->isColumnModified(InventarioPeer::FECHA)) {
            $modifiedColumns[':p' . $index++]  = '`fecha`';
        }
        if ($this->isColumnModified(InventarioPeer::STOCK)) {
            $modifiedColumns[':p' . $index++]  = '`stock`';
        }
        if ($this->isColumnModified(InventarioPeer::PRECIO_UNITARIO)) {
            $modifiedColumns[':p' . $index++]  = '`precio_unitario`';
        }
        if ($this->isColumnModified(InventarioPeer::NETO)) {
            $modifiedColumns[':p' . $index++]  = '`neto`';
        }
        if ($this->isColumnModified(InventarioPeer::TOTAL)) {
            $modifiedColumns[':p' . $index++]  = '`total`';
        }

        $sql = sprintf(
            'INSERT INTO `inventario` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`producto_id`':
                        $stmt->bindValue($identifier, $this->producto_id, PDO::PARAM_INT);
                        break;
                    case '`proveedor_id`':
                        $stmt->bindValue($identifier, $this->proveedor_id, PDO::PARAM_INT);
                        break;
                    case '`fecha`':
                        $stmt->bindValue($identifier, $this->fecha, PDO::PARAM_STR);
                        break;
                    case '`stock`':
                        $stmt->bindValue($identifier, $this->stock, PDO::PARAM_INT);
                        break;
                    case '`precio_unitario`':
                        $stmt->bindValue($identifier, $this->precio_unitario, PDO::PARAM_STR);
                        break;
                    case '`neto`':
                        $stmt->bindValue($identifier, $this->neto, PDO::PARAM_STR);
                        break;
                    case '`total`':
                        $stmt->bindValue($identifier, $this->total, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aProducto !== null) {
                if (!$this->aProducto->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProducto->getValidationFailures());
                }
            }

            if ($this->aProveedor !== null) {
                if (!$this->aProveedor->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProveedor->getValidationFailures());
                }
            }


            if (($retval = InventarioPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collComprass !== null) {
                    foreach ($this->collComprass as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collVentass !== null) {
                    foreach ($this->collVentass as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = InventarioPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getProductoId();
                break;
            case 2:
                return $this->getProveedorId();
                break;
            case 3:
                return $this->getFecha();
                break;
            case 4:
                return $this->getStock();
                break;
            case 5:
                return $this->getPrecioUnitario();
                break;
            case 6:
                return $this->getNeto();
                break;
            case 7:
                return $this->getTotal();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Inventario'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Inventario'][$this->getPrimaryKey()] = true;
        $keys = InventarioPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getProductoId(),
            $keys[2] => $this->getProveedorId(),
            $keys[3] => $this->getFecha(),
            $keys[4] => $this->getStock(),
            $keys[5] => $this->getPrecioUnitario(),
            $keys[6] => $this->getNeto(),
            $keys[7] => $this->getTotal(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProducto) {
                $result['Producto'] = $this->aProducto->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProveedor) {
                $result['Proveedor'] = $this->aProveedor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collComprass) {
                $result['Comprass'] = $this->collComprass->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collVentass) {
                $result['Ventass'] = $this->collVentass->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = InventarioPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setProductoId($value);
                break;
            case 2:
                $this->setProveedorId($value);
                break;
            case 3:
                $this->setFecha($value);
                break;
            case 4:
                $this->setStock($value);
                break;
            case 5:
                $this->setPrecioUnitario($value);
                break;
            case 6:
                $this->setNeto($value);
                break;
            case 7:
                $this->setTotal($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = InventarioPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setProductoId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setProveedorId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setFecha($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setStock($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPrecioUnitario($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setNeto($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setTotal($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(InventarioPeer::DATABASE_NAME);

        if ($this->isColumnModified(InventarioPeer::ID)) $criteria->add(InventarioPeer::ID, $this->id);
        if ($this->isColumnModified(InventarioPeer::PRODUCTO_ID)) $criteria->add(InventarioPeer::PRODUCTO_ID, $this->producto_id);
        if ($this->isColumnModified(InventarioPeer::PROVEEDOR_ID)) $criteria->add(InventarioPeer::PROVEEDOR_ID, $this->proveedor_id);
        if ($this->isColumnModified(InventarioPeer::FECHA)) $criteria->add(InventarioPeer::FECHA, $this->fecha);
        if ($this->isColumnModified(InventarioPeer::STOCK)) $criteria->add(InventarioPeer::STOCK, $this->stock);
        if ($this->isColumnModified(InventarioPeer::PRECIO_UNITARIO)) $criteria->add(InventarioPeer::PRECIO_UNITARIO, $this->precio_unitario);
        if ($this->isColumnModified(InventarioPeer::NETO)) $criteria->add(InventarioPeer::NETO, $this->neto);
        if ($this->isColumnModified(InventarioPeer::TOTAL)) $criteria->add(InventarioPeer::TOTAL, $this->total);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(InventarioPeer::DATABASE_NAME);
        $criteria->add(InventarioPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Inventario (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProductoId($this->getProductoId());
        $copyObj->setProveedorId($this->getProveedorId());
        $copyObj->setFecha($this->getFecha());
        $copyObj->setStock($this->getStock());
        $copyObj->setPrecioUnitario($this->getPrecioUnitario());
        $copyObj->setNeto($this->getNeto());
        $copyObj->setTotal($this->getTotal());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getComprass() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCompras($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getVentass() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVentas($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Inventario Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return InventarioPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new InventarioPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Producto object.
     *
     * @param                  Producto $v
     * @return Inventario The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProducto(Producto $v = null)
    {
        if ($v === null) {
            $this->setProductoId(NULL);
        } else {
            $this->setProductoId($v->getId());
        }

        $this->aProducto = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Producto object, it will not be re-added.
        if ($v !== null) {
            $v->addInventario($this);
        }


        return $this;
    }


    /**
     * Get the associated Producto object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Producto The associated Producto object.
     * @throws PropelException
     */
    public function getProducto(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aProducto === null && ($this->producto_id !== null) && $doQuery) {
            $this->aProducto = ProductoQuery::create()->findPk($this->producto_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProducto->addInventarios($this);
             */
        }

        return $this->aProducto;
    }

    /**
     * Declares an association between this object and a Proveedor object.
     *
     * @param                  Proveedor $v
     * @return Inventario The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProveedor(Proveedor $v = null)
    {
        if ($v === null) {
            $this->setProveedorId(NULL);
        } else {
            $this->setProveedorId($v->getId());
        }

        $this->aProveedor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Proveedor object, it will not be re-added.
        if ($v !== null) {
            $v->addInventario($this);
        }


        return $this;
    }


    /**
     * Get the associated Proveedor object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Proveedor The associated Proveedor object.
     * @throws PropelException
     */
    public function getProveedor(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aProveedor === null && ($this->proveedor_id !== null) && $doQuery) {
            $this->aProveedor = ProveedorQuery::create()->findPk($this->proveedor_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProveedor->addInventarios($this);
             */
        }

        return $this->aProveedor;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Compras' == $relationName) {
            $this->initComprass();
        }
        if ('Ventas' == $relationName) {
            $this->initVentass();
        }
    }

    /**
     * Clears out the collComprass collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Inventario The current object (for fluent API support)
     * @see        addComprass()
     */
    public function clearComprass()
    {
        $this->collComprass = null; // important to set this to null since that means it is uninitialized
        $this->collComprassPartial = null;

        return $this;
    }

    /**
     * reset is the collComprass collection loaded partially
     *
     * @return void
     */
    public function resetPartialComprass($v = true)
    {
        $this->collComprassPartial = $v;
    }

    /**
     * Initializes the collComprass collection.
     *
     * By default this just sets the collComprass collection to an empty array (like clearcollComprass());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initComprass($overrideExisting = true)
    {
        if (null !== $this->collComprass && !$overrideExisting) {
            return;
        }
        $this->collComprass = new PropelObjectCollection();
        $this->collComprass->setModel('Compras');
    }

    /**
     * Gets an array of Compras objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Inventario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Compras[] List of Compras objects
     * @throws PropelException
     */
    public function getComprass($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collComprassPartial && !$this->isNew();
        if (null === $this->collComprass || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collComprass) {
                // return empty collection
                $this->initComprass();
            } else {
                $collComprass = ComprasQuery::create(null, $criteria)
                    ->filterByInventario($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collComprassPartial && count($collComprass)) {
                      $this->initComprass(false);

                      foreach ($collComprass as $obj) {
                        if (false == $this->collComprass->contains($obj)) {
                          $this->collComprass->append($obj);
                        }
                      }

                      $this->collComprassPartial = true;
                    }

                    $collComprass->getInternalIterator()->rewind();

                    return $collComprass;
                }

                if ($partial && $this->collComprass) {
                    foreach ($this->collComprass as $obj) {
                        if ($obj->isNew()) {
                            $collComprass[] = $obj;
                        }
                    }
                }

                $this->collComprass = $collComprass;
                $this->collComprassPartial = false;
            }
        }

        return $this->collComprass;
    }

    /**
     * Sets a collection of Compras objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $comprass A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Inventario The current object (for fluent API support)
     */
    public function setComprass(PropelCollection $comprass, PropelPDO $con = null)
    {
        $comprassToDelete = $this->getComprass(new Criteria(), $con)->diff($comprass);


        $this->comprassScheduledForDeletion = $comprassToDelete;

        foreach ($comprassToDelete as $comprasRemoved) {
            $comprasRemoved->setInventario(null);
        }

        $this->collComprass = null;
        foreach ($comprass as $compras) {
            $this->addCompras($compras);
        }

        $this->collComprass = $comprass;
        $this->collComprassPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Compras objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Compras objects.
     * @throws PropelException
     */
    public function countComprass(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collComprassPartial && !$this->isNew();
        if (null === $this->collComprass || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collComprass) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getComprass());
            }
            $query = ComprasQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInventario($this)
                ->count($con);
        }

        return count($this->collComprass);
    }

    /**
     * Method called to associate a Compras object to this object
     * through the Compras foreign key attribute.
     *
     * @param    Compras $l Compras
     * @return Inventario The current object (for fluent API support)
     */
    public function addCompras(Compras $l)
    {
        if ($this->collComprass === null) {
            $this->initComprass();
            $this->collComprassPartial = true;
        }

        if (!in_array($l, $this->collComprass->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCompras($l);

            if ($this->comprassScheduledForDeletion and $this->comprassScheduledForDeletion->contains($l)) {
                $this->comprassScheduledForDeletion->remove($this->comprassScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Compras $compras The compras object to add.
     */
    protected function doAddCompras($compras)
    {
        $this->collComprass[]= $compras;
        $compras->setInventario($this);
    }

    /**
     * @param	Compras $compras The compras object to remove.
     * @return Inventario The current object (for fluent API support)
     */
    public function removeCompras($compras)
    {
        if ($this->getComprass()->contains($compras)) {
            $this->collComprass->remove($this->collComprass->search($compras));
            if (null === $this->comprassScheduledForDeletion) {
                $this->comprassScheduledForDeletion = clone $this->collComprass;
                $this->comprassScheduledForDeletion->clear();
            }
            $this->comprassScheduledForDeletion[]= $compras;
            $compras->setInventario(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Inventario is new, it will return
     * an empty collection; or if this Inventario has previously
     * been saved, it will retrieve related Comprass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Inventario.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Compras[] List of Compras objects
     */
    public function getComprassJoinProveedor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ComprasQuery::create(null, $criteria);
        $query->joinWith('Proveedor', $join_behavior);

        return $this->getComprass($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Inventario is new, it will return
     * an empty collection; or if this Inventario has previously
     * been saved, it will retrieve related Comprass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Inventario.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Compras[] List of Compras objects
     */
    public function getComprassJoinFactura($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ComprasQuery::create(null, $criteria);
        $query->joinWith('Factura', $join_behavior);

        return $this->getComprass($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Inventario is new, it will return
     * an empty collection; or if this Inventario has previously
     * been saved, it will retrieve related Comprass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Inventario.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Compras[] List of Compras objects
     */
    public function getComprassJoinProducto($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ComprasQuery::create(null, $criteria);
        $query->joinWith('Producto', $join_behavior);

        return $this->getComprass($query, $con);
    }

    /**
     * Clears out the collVentass collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Inventario The current object (for fluent API support)
     * @see        addVentass()
     */
    public function clearVentass()
    {
        $this->collVentass = null; // important to set this to null since that means it is uninitialized
        $this->collVentassPartial = null;

        return $this;
    }

    /**
     * reset is the collVentass collection loaded partially
     *
     * @return void
     */
    public function resetPartialVentass($v = true)
    {
        $this->collVentassPartial = $v;
    }

    /**
     * Initializes the collVentass collection.
     *
     * By default this just sets the collVentass collection to an empty array (like clearcollVentass());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVentass($overrideExisting = true)
    {
        if (null !== $this->collVentass && !$overrideExisting) {
            return;
        }
        $this->collVentass = new PropelObjectCollection();
        $this->collVentass->setModel('Ventas');
    }

    /**
     * Gets an array of Ventas objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Inventario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Ventas[] List of Ventas objects
     * @throws PropelException
     */
    public function getVentass($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collVentassPartial && !$this->isNew();
        if (null === $this->collVentass || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVentass) {
                // return empty collection
                $this->initVentass();
            } else {
                $collVentass = VentasQuery::create(null, $criteria)
                    ->filterByInventario($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collVentassPartial && count($collVentass)) {
                      $this->initVentass(false);

                      foreach ($collVentass as $obj) {
                        if (false == $this->collVentass->contains($obj)) {
                          $this->collVentass->append($obj);
                        }
                      }

                      $this->collVentassPartial = true;
                    }

                    $collVentass->getInternalIterator()->rewind();

                    return $collVentass;
                }

                if ($partial && $this->collVentass) {
                    foreach ($this->collVentass as $obj) {
                        if ($obj->isNew()) {
                            $collVentass[] = $obj;
                        }
                    }
                }

                $this->collVentass = $collVentass;
                $this->collVentassPartial = false;
            }
        }

        return $this->collVentass;
    }

    /**
     * Sets a collection of Ventas objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $ventass A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Inventario The current object (for fluent API support)
     */
    public function setVentass(PropelCollection $ventass, PropelPDO $con = null)
    {
        $ventassToDelete = $this->getVentass(new Criteria(), $con)->diff($ventass);


        $this->ventassScheduledForDeletion = $ventassToDelete;

        foreach ($ventassToDelete as $ventasRemoved) {
            $ventasRemoved->setInventario(null);
        }

        $this->collVentass = null;
        foreach ($ventass as $ventas) {
            $this->addVentas($ventas);
        }

        $this->collVentass = $ventass;
        $this->collVentassPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Ventas objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Ventas objects.
     * @throws PropelException
     */
    public function countVentass(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collVentassPartial && !$this->isNew();
        if (null === $this->collVentass || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVentass) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVentass());
            }
            $query = VentasQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInventario($this)
                ->count($con);
        }

        return count($this->collVentass);
    }

    /**
     * Method called to associate a Ventas object to this object
     * through the Ventas foreign key attribute.
     *
     * @param    Ventas $l Ventas
     * @return Inventario The current object (for fluent API support)
     */
    public function addVentas(Ventas $l)
    {
        if ($this->collVentass === null) {
            $this->initVentass();
            $this->collVentassPartial = true;
        }

        if (!in_array($l, $this->collVentass->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddVentas($l);

            if ($this->ventassScheduledForDeletion and $this->ventassScheduledForDeletion->contains($l)) {
                $this->ventassScheduledForDeletion->remove($this->ventassScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Ventas $ventas The ventas object to add.
     */
    protected function doAddVentas($ventas)
    {
        $this->collVentass[]= $ventas;
        $ventas->setInventario($this);
    }

    /**
     * @param	Ventas $ventas The ventas object to remove.
     * @return Inventario The current object (for fluent API support)
     */
    public function removeVentas($ventas)
    {
        if ($this->getVentass()->contains($ventas)) {
            $this->collVentass->remove($this->collVentass->search($ventas));
            if (null === $this->ventassScheduledForDeletion) {
                $this->ventassScheduledForDeletion = clone $this->collVentass;
                $this->ventassScheduledForDeletion->clear();
            }
            $this->ventassScheduledForDeletion[]= $ventas;
            $ventas->setInventario(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Inventario is new, it will return
     * an empty collection; or if this Inventario has previously
     * been saved, it will retrieve related Ventass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Inventario.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Ventas[] List of Ventas objects
     */
    public function getVentassJoinClientes($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = VentasQuery::create(null, $criteria);
        $query->joinWith('Clientes', $join_behavior);

        return $this->getVentass($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Inventario is new, it will return
     * an empty collection; or if this Inventario has previously
     * been saved, it will retrieve related Ventass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Inventario.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Ventas[] List of Ventas objects
     */
    public function getVentassJoinFactura($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = VentasQuery::create(null, $criteria);
        $query->joinWith('Factura', $join_behavior);

        return $this->getVentass($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->producto_id = null;
        $this->proveedor_id = null;
        $this->fecha = null;
        $this->stock = null;
        $this->precio_unitario = null;
        $this->neto = null;
        $this->total = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collComprass) {
                foreach ($this->collComprass as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVentass) {
                foreach ($this->collVentass as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aProducto instanceof Persistent) {
              $this->aProducto->clearAllReferences($deep);
            }
            if ($this->aProveedor instanceof Persistent) {
              $this->aProveedor->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collComprass instanceof PropelCollection) {
            $this->collComprass->clearIterator();
        }
        $this->collComprass = null;
        if ($this->collVentass instanceof PropelCollection) {
            $this->collVentass->clearIterator();
        }
        $this->collVentass = null;
        $this->aProducto = null;
        $this->aProveedor = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(InventarioPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
