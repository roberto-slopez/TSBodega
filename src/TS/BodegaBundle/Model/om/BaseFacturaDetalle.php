<?php

namespace TS\BodegaBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelException;
use \PropelPDO;
use TS\BodegaBundle\Model\Factura;
use TS\BodegaBundle\Model\FacturaDetalle;
use TS\BodegaBundle\Model\FacturaDetallePeer;
use TS\BodegaBundle\Model\FacturaDetalleQuery;
use TS\BodegaBundle\Model\FacturaQuery;
use TS\BodegaBundle\Model\Producto;
use TS\BodegaBundle\Model\ProductoQuery;

abstract class BaseFacturaDetalle extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'TS\\BodegaBundle\\Model\\FacturaDetallePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        FacturaDetallePeer
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
     * The value for the factura_id field.
     * @var        int
     */
    protected $factura_id;

    /**
     * The value for the cantidad field.
     * @var        int
     */
    protected $cantidad;

    /**
     * The value for the producto_id field.
     * @var        int
     */
    protected $producto_id;

    /**
     * The value for the precio_unitario field.
     * @var        string
     */
    protected $precio_unitario;

    /**
     * The value for the subtotal field.
     * @var        string
     */
    protected $subtotal;

    /**
     * @var        Producto
     */
    protected $aProducto;

    /**
     * @var        Factura
     */
    protected $aFactura;

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
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [factura_id] column value.
     *
     * @return int
     */
    public function getFacturaId()
    {

        return $this->factura_id;
    }

    /**
     * Get the [cantidad] column value.
     *
     * @return int
     */
    public function getCantidad()
    {

        return $this->cantidad;
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
     * Get the [precio_unitario] column value.
     *
     * @return string
     */
    public function getPrecioUnitario()
    {

        return $this->precio_unitario;
    }

    /**
     * Get the [subtotal] column value.
     *
     * @return string
     */
    public function getSubtotal()
    {

        return $this->subtotal;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return FacturaDetalle The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = FacturaDetallePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [factura_id] column.
     *
     * @param  int $v new value
     * @return FacturaDetalle The current object (for fluent API support)
     */
    public function setFacturaId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->factura_id !== $v) {
            $this->factura_id = $v;
            $this->modifiedColumns[] = FacturaDetallePeer::FACTURA_ID;
        }

        if ($this->aFactura !== null && $this->aFactura->getId() !== $v) {
            $this->aFactura = null;
        }


        return $this;
    } // setFacturaId()

    /**
     * Set the value of [cantidad] column.
     *
     * @param  int $v new value
     * @return FacturaDetalle The current object (for fluent API support)
     */
    public function setCantidad($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cantidad !== $v) {
            $this->cantidad = $v;
            $this->modifiedColumns[] = FacturaDetallePeer::CANTIDAD;
        }


        return $this;
    } // setCantidad()

    /**
     * Set the value of [producto_id] column.
     *
     * @param  int $v new value
     * @return FacturaDetalle The current object (for fluent API support)
     */
    public function setProductoId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->producto_id !== $v) {
            $this->producto_id = $v;
            $this->modifiedColumns[] = FacturaDetallePeer::PRODUCTO_ID;
        }

        if ($this->aProducto !== null && $this->aProducto->getId() !== $v) {
            $this->aProducto = null;
        }


        return $this;
    } // setProductoId()

    /**
     * Set the value of [precio_unitario] column.
     *
     * @param  string $v new value
     * @return FacturaDetalle The current object (for fluent API support)
     */
    public function setPrecioUnitario($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->precio_unitario !== $v) {
            $this->precio_unitario = $v;
            $this->modifiedColumns[] = FacturaDetallePeer::PRECIO_UNITARIO;
        }


        return $this;
    } // setPrecioUnitario()

    /**
     * Set the value of [subtotal] column.
     *
     * @param  string $v new value
     * @return FacturaDetalle The current object (for fluent API support)
     */
    public function setSubtotal($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->subtotal !== $v) {
            $this->subtotal = $v;
            $this->modifiedColumns[] = FacturaDetallePeer::SUBTOTAL;
        }


        return $this;
    } // setSubtotal()

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
            $this->factura_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->cantidad = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->producto_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->precio_unitario = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->subtotal = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 6; // 6 = FacturaDetallePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating FacturaDetalle object", $e);
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

        if ($this->aFactura !== null && $this->factura_id !== $this->aFactura->getId()) {
            $this->aFactura = null;
        }
        if ($this->aProducto !== null && $this->producto_id !== $this->aProducto->getId()) {
            $this->aProducto = null;
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
            $con = Propel::getConnection(FacturaDetallePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = FacturaDetallePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProducto = null;
            $this->aFactura = null;
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
            $con = Propel::getConnection(FacturaDetallePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = FacturaDetalleQuery::create()
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
            $con = Propel::getConnection(FacturaDetallePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                FacturaDetallePeer::addInstanceToPool($this);
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

            if ($this->aFactura !== null) {
                if ($this->aFactura->isModified() || $this->aFactura->isNew()) {
                    $affectedRows += $this->aFactura->save($con);
                }
                $this->setFactura($this->aFactura);
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

        $this->modifiedColumns[] = FacturaDetallePeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FacturaDetallePeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FacturaDetallePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(FacturaDetallePeer::FACTURA_ID)) {
            $modifiedColumns[':p' . $index++]  = '`factura_id`';
        }
        if ($this->isColumnModified(FacturaDetallePeer::CANTIDAD)) {
            $modifiedColumns[':p' . $index++]  = '`cantidad`';
        }
        if ($this->isColumnModified(FacturaDetallePeer::PRODUCTO_ID)) {
            $modifiedColumns[':p' . $index++]  = '`producto_id`';
        }
        if ($this->isColumnModified(FacturaDetallePeer::PRECIO_UNITARIO)) {
            $modifiedColumns[':p' . $index++]  = '`precio_unitario`';
        }
        if ($this->isColumnModified(FacturaDetallePeer::SUBTOTAL)) {
            $modifiedColumns[':p' . $index++]  = '`subtotal`';
        }

        $sql = sprintf(
            'INSERT INTO `factura_detalle` (%s) VALUES (%s)',
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
                    case '`factura_id`':
                        $stmt->bindValue($identifier, $this->factura_id, PDO::PARAM_INT);
                        break;
                    case '`cantidad`':
                        $stmt->bindValue($identifier, $this->cantidad, PDO::PARAM_INT);
                        break;
                    case '`producto_id`':
                        $stmt->bindValue($identifier, $this->producto_id, PDO::PARAM_INT);
                        break;
                    case '`precio_unitario`':
                        $stmt->bindValue($identifier, $this->precio_unitario, PDO::PARAM_STR);
                        break;
                    case '`subtotal`':
                        $stmt->bindValue($identifier, $this->subtotal, PDO::PARAM_STR);
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

            if ($this->aFactura !== null) {
                if (!$this->aFactura->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFactura->getValidationFailures());
                }
            }


            if (($retval = FacturaDetallePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = FacturaDetallePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFacturaId();
                break;
            case 2:
                return $this->getCantidad();
                break;
            case 3:
                return $this->getProductoId();
                break;
            case 4:
                return $this->getPrecioUnitario();
                break;
            case 5:
                return $this->getSubtotal();
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
        if (isset($alreadyDumpedObjects['FacturaDetalle'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['FacturaDetalle'][$this->getPrimaryKey()] = true;
        $keys = FacturaDetallePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFacturaId(),
            $keys[2] => $this->getCantidad(),
            $keys[3] => $this->getProductoId(),
            $keys[4] => $this->getPrecioUnitario(),
            $keys[5] => $this->getSubtotal(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProducto) {
                $result['Producto'] = $this->aProducto->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aFactura) {
                $result['Factura'] = $this->aFactura->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = FacturaDetallePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFacturaId($value);
                break;
            case 2:
                $this->setCantidad($value);
                break;
            case 3:
                $this->setProductoId($value);
                break;
            case 4:
                $this->setPrecioUnitario($value);
                break;
            case 5:
                $this->setSubtotal($value);
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
        $keys = FacturaDetallePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFacturaId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setCantidad($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setProductoId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPrecioUnitario($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSubtotal($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FacturaDetallePeer::DATABASE_NAME);

        if ($this->isColumnModified(FacturaDetallePeer::ID)) $criteria->add(FacturaDetallePeer::ID, $this->id);
        if ($this->isColumnModified(FacturaDetallePeer::FACTURA_ID)) $criteria->add(FacturaDetallePeer::FACTURA_ID, $this->factura_id);
        if ($this->isColumnModified(FacturaDetallePeer::CANTIDAD)) $criteria->add(FacturaDetallePeer::CANTIDAD, $this->cantidad);
        if ($this->isColumnModified(FacturaDetallePeer::PRODUCTO_ID)) $criteria->add(FacturaDetallePeer::PRODUCTO_ID, $this->producto_id);
        if ($this->isColumnModified(FacturaDetallePeer::PRECIO_UNITARIO)) $criteria->add(FacturaDetallePeer::PRECIO_UNITARIO, $this->precio_unitario);
        if ($this->isColumnModified(FacturaDetallePeer::SUBTOTAL)) $criteria->add(FacturaDetallePeer::SUBTOTAL, $this->subtotal);

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
        $criteria = new Criteria(FacturaDetallePeer::DATABASE_NAME);
        $criteria->add(FacturaDetallePeer::ID, $this->id);

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
     * @param object $copyObj An object of FacturaDetalle (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFacturaId($this->getFacturaId());
        $copyObj->setCantidad($this->getCantidad());
        $copyObj->setProductoId($this->getProductoId());
        $copyObj->setPrecioUnitario($this->getPrecioUnitario());
        $copyObj->setSubtotal($this->getSubtotal());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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
     * @return FacturaDetalle Clone of current object.
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
     * @return FacturaDetallePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new FacturaDetallePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Producto object.
     *
     * @param                  Producto $v
     * @return FacturaDetalle The current object (for fluent API support)
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
            $v->addFacturaDetalle($this);
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
                $this->aProducto->addFacturaDetalles($this);
             */
        }

        return $this->aProducto;
    }

    /**
     * Declares an association between this object and a Factura object.
     *
     * @param                  Factura $v
     * @return FacturaDetalle The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFactura(Factura $v = null)
    {
        if ($v === null) {
            $this->setFacturaId(NULL);
        } else {
            $this->setFacturaId($v->getId());
        }

        $this->aFactura = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Factura object, it will not be re-added.
        if ($v !== null) {
            $v->addFacturaDetalle($this);
        }


        return $this;
    }


    /**
     * Get the associated Factura object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Factura The associated Factura object.
     * @throws PropelException
     */
    public function getFactura(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aFactura === null && ($this->factura_id !== null) && $doQuery) {
            $this->aFactura = FacturaQuery::create()->findPk($this->factura_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFactura->addFacturaDetalles($this);
             */
        }

        return $this->aFactura;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->factura_id = null;
        $this->cantidad = null;
        $this->producto_id = null;
        $this->precio_unitario = null;
        $this->subtotal = null;
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
            if ($this->aProducto instanceof Persistent) {
              $this->aProducto->clearAllReferences($deep);
            }
            if ($this->aFactura instanceof Persistent) {
              $this->aFactura->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aProducto = null;
        $this->aFactura = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FacturaDetallePeer::DEFAULT_STRING_FORMAT);
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
