<?php

namespace TS\BodegaBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use TS\BodegaBundle\Model\Compras;
use TS\BodegaBundle\Model\ComprasQuery;
use TS\BodegaBundle\Model\Inventario;
use TS\BodegaBundle\Model\InventarioQuery;
use TS\BodegaBundle\Model\Proveedor;
use TS\BodegaBundle\Model\ProveedorPeer;
use TS\BodegaBundle\Model\ProveedorQuery;

abstract class BaseProveedor extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'TS\\BodegaBundle\\Model\\ProveedorPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProveedorPeer
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
     * The value for the nombre field.
     * @var        string
     */
    protected $nombre;

    /**
     * The value for the encargado field.
     * @var        string
     */
    protected $encargado;

    /**
     * The value for the nit field.
     * @var        string
     */
    protected $nit;

    /**
     * The value for the dpi field.
     * @var        string
     */
    protected $dpi;

    /**
     * The value for the direccion field.
     * @var        string
     */
    protected $direccion;

    /**
     * The value for the telefono field.
     * @var        string
     */
    protected $telefono;

    /**
     * The value for the movil field.
     * @var        string
     */
    protected $movil;

    /**
     * @var        PropelObjectCollection|Compras[] Collection to store aggregation of Compras objects.
     */
    protected $collComprass;
    protected $collComprassPartial;

    /**
     * @var        PropelObjectCollection|Inventario[] Collection to store aggregation of Inventario objects.
     */
    protected $collInventarios;
    protected $collInventariosPartial;

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
    protected $inventariosScheduledForDeletion = null;

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
     * Get the [nombre] column value.
     *
     * @return string
     */
    public function getNombre()
    {

        return $this->nombre;
    }

    /**
     * Get the [encargado] column value.
     *
     * @return string
     */
    public function getEncargado()
    {

        return $this->encargado;
    }

    /**
     * Get the [nit] column value.
     *
     * @return string
     */
    public function getNit()
    {

        return $this->nit;
    }

    /**
     * Get the [dpi] column value.
     *
     * @return string
     */
    public function getDpi()
    {

        return $this->dpi;
    }

    /**
     * Get the [direccion] column value.
     *
     * @return string
     */
    public function getDireccion()
    {

        return $this->direccion;
    }

    /**
     * Get the [telefono] column value.
     *
     * @return string
     */
    public function getTelefono()
    {

        return $this->telefono;
    }

    /**
     * Get the [movil] column value.
     *
     * @return string
     */
    public function getMovil()
    {

        return $this->movil;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Proveedor The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ProveedorPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [nombre] column.
     *
     * @param  string $v new value
     * @return Proveedor The current object (for fluent API support)
     */
    public function setNombre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombre !== $v) {
            $this->nombre = $v;
            $this->modifiedColumns[] = ProveedorPeer::NOMBRE;
        }


        return $this;
    } // setNombre()

    /**
     * Set the value of [encargado] column.
     *
     * @param  string $v new value
     * @return Proveedor The current object (for fluent API support)
     */
    public function setEncargado($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->encargado !== $v) {
            $this->encargado = $v;
            $this->modifiedColumns[] = ProveedorPeer::ENCARGADO;
        }


        return $this;
    } // setEncargado()

    /**
     * Set the value of [nit] column.
     *
     * @param  string $v new value
     * @return Proveedor The current object (for fluent API support)
     */
    public function setNit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nit !== $v) {
            $this->nit = $v;
            $this->modifiedColumns[] = ProveedorPeer::NIT;
        }


        return $this;
    } // setNit()

    /**
     * Set the value of [dpi] column.
     *
     * @param  string $v new value
     * @return Proveedor The current object (for fluent API support)
     */
    public function setDpi($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->dpi !== $v) {
            $this->dpi = $v;
            $this->modifiedColumns[] = ProveedorPeer::DPI;
        }


        return $this;
    } // setDpi()

    /**
     * Set the value of [direccion] column.
     *
     * @param  string $v new value
     * @return Proveedor The current object (for fluent API support)
     */
    public function setDireccion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->direccion !== $v) {
            $this->direccion = $v;
            $this->modifiedColumns[] = ProveedorPeer::DIRECCION;
        }


        return $this;
    } // setDireccion()

    /**
     * Set the value of [telefono] column.
     *
     * @param  string $v new value
     * @return Proveedor The current object (for fluent API support)
     */
    public function setTelefono($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->telefono !== $v) {
            $this->telefono = $v;
            $this->modifiedColumns[] = ProveedorPeer::TELEFONO;
        }


        return $this;
    } // setTelefono()

    /**
     * Set the value of [movil] column.
     *
     * @param  string $v new value
     * @return Proveedor The current object (for fluent API support)
     */
    public function setMovil($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->movil !== $v) {
            $this->movil = $v;
            $this->modifiedColumns[] = ProveedorPeer::MOVIL;
        }


        return $this;
    } // setMovil()

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
            $this->nombre = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->encargado = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->nit = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->dpi = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->direccion = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->telefono = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->movil = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = ProveedorPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Proveedor object", $e);
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
            $con = Propel::getConnection(ProveedorPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProveedorPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collComprass = null;

            $this->collInventarios = null;

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
            $con = Propel::getConnection(ProveedorPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProveedorQuery::create()
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
            $con = Propel::getConnection(ProveedorPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ProveedorPeer::addInstanceToPool($this);
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

            if ($this->inventariosScheduledForDeletion !== null) {
                if (!$this->inventariosScheduledForDeletion->isEmpty()) {
                    foreach ($this->inventariosScheduledForDeletion as $inventario) {
                        // need to save related object because we set the relation to null
                        $inventario->save($con);
                    }
                    $this->inventariosScheduledForDeletion = null;
                }
            }

            if ($this->collInventarios !== null) {
                foreach ($this->collInventarios as $referrerFK) {
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

        $this->modifiedColumns[] = ProveedorPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProveedorPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProveedorPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ProveedorPeer::NOMBRE)) {
            $modifiedColumns[':p' . $index++]  = '`nombre`';
        }
        if ($this->isColumnModified(ProveedorPeer::ENCARGADO)) {
            $modifiedColumns[':p' . $index++]  = '`encargado`';
        }
        if ($this->isColumnModified(ProveedorPeer::NIT)) {
            $modifiedColumns[':p' . $index++]  = '`nit`';
        }
        if ($this->isColumnModified(ProveedorPeer::DPI)) {
            $modifiedColumns[':p' . $index++]  = '`dpi`';
        }
        if ($this->isColumnModified(ProveedorPeer::DIRECCION)) {
            $modifiedColumns[':p' . $index++]  = '`direccion`';
        }
        if ($this->isColumnModified(ProveedorPeer::TELEFONO)) {
            $modifiedColumns[':p' . $index++]  = '`telefono`';
        }
        if ($this->isColumnModified(ProveedorPeer::MOVIL)) {
            $modifiedColumns[':p' . $index++]  = '`movil`';
        }

        $sql = sprintf(
            'INSERT INTO `proveedor` (%s) VALUES (%s)',
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
                    case '`nombre`':
                        $stmt->bindValue($identifier, $this->nombre, PDO::PARAM_STR);
                        break;
                    case '`encargado`':
                        $stmt->bindValue($identifier, $this->encargado, PDO::PARAM_STR);
                        break;
                    case '`nit`':
                        $stmt->bindValue($identifier, $this->nit, PDO::PARAM_STR);
                        break;
                    case '`dpi`':
                        $stmt->bindValue($identifier, $this->dpi, PDO::PARAM_STR);
                        break;
                    case '`direccion`':
                        $stmt->bindValue($identifier, $this->direccion, PDO::PARAM_STR);
                        break;
                    case '`telefono`':
                        $stmt->bindValue($identifier, $this->telefono, PDO::PARAM_STR);
                        break;
                    case '`movil`':
                        $stmt->bindValue($identifier, $this->movil, PDO::PARAM_STR);
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


            if (($retval = ProveedorPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collComprass !== null) {
                    foreach ($this->collComprass as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collInventarios !== null) {
                    foreach ($this->collInventarios as $referrerFK) {
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
        $pos = ProveedorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getNombre();
                break;
            case 2:
                return $this->getEncargado();
                break;
            case 3:
                return $this->getNit();
                break;
            case 4:
                return $this->getDpi();
                break;
            case 5:
                return $this->getDireccion();
                break;
            case 6:
                return $this->getTelefono();
                break;
            case 7:
                return $this->getMovil();
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
        if (isset($alreadyDumpedObjects['Proveedor'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Proveedor'][$this->getPrimaryKey()] = true;
        $keys = ProveedorPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getNombre(),
            $keys[2] => $this->getEncargado(),
            $keys[3] => $this->getNit(),
            $keys[4] => $this->getDpi(),
            $keys[5] => $this->getDireccion(),
            $keys[6] => $this->getTelefono(),
            $keys[7] => $this->getMovil(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collComprass) {
                $result['Comprass'] = $this->collComprass->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collInventarios) {
                $result['Inventarios'] = $this->collInventarios->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ProveedorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setNombre($value);
                break;
            case 2:
                $this->setEncargado($value);
                break;
            case 3:
                $this->setNit($value);
                break;
            case 4:
                $this->setDpi($value);
                break;
            case 5:
                $this->setDireccion($value);
                break;
            case 6:
                $this->setTelefono($value);
                break;
            case 7:
                $this->setMovil($value);
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
        $keys = ProveedorPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setNombre($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setEncargado($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setNit($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDpi($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDireccion($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setTelefono($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setMovil($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProveedorPeer::DATABASE_NAME);

        if ($this->isColumnModified(ProveedorPeer::ID)) $criteria->add(ProveedorPeer::ID, $this->id);
        if ($this->isColumnModified(ProveedorPeer::NOMBRE)) $criteria->add(ProveedorPeer::NOMBRE, $this->nombre);
        if ($this->isColumnModified(ProveedorPeer::ENCARGADO)) $criteria->add(ProveedorPeer::ENCARGADO, $this->encargado);
        if ($this->isColumnModified(ProveedorPeer::NIT)) $criteria->add(ProveedorPeer::NIT, $this->nit);
        if ($this->isColumnModified(ProveedorPeer::DPI)) $criteria->add(ProveedorPeer::DPI, $this->dpi);
        if ($this->isColumnModified(ProveedorPeer::DIRECCION)) $criteria->add(ProveedorPeer::DIRECCION, $this->direccion);
        if ($this->isColumnModified(ProveedorPeer::TELEFONO)) $criteria->add(ProveedorPeer::TELEFONO, $this->telefono);
        if ($this->isColumnModified(ProveedorPeer::MOVIL)) $criteria->add(ProveedorPeer::MOVIL, $this->movil);

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
        $criteria = new Criteria(ProveedorPeer::DATABASE_NAME);
        $criteria->add(ProveedorPeer::ID, $this->id);

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
     * @param object $copyObj An object of Proveedor (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setNombre($this->getNombre());
        $copyObj->setEncargado($this->getEncargado());
        $copyObj->setNit($this->getNit());
        $copyObj->setDpi($this->getDpi());
        $copyObj->setDireccion($this->getDireccion());
        $copyObj->setTelefono($this->getTelefono());
        $copyObj->setMovil($this->getMovil());

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

            foreach ($this->getInventarios() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInventario($relObj->copy($deepCopy));
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
     * @return Proveedor Clone of current object.
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
     * @return ProveedorPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProveedorPeer();
        }

        return self::$peer;
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
        if ('Inventario' == $relationName) {
            $this->initInventarios();
        }
    }

    /**
     * Clears out the collComprass collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Proveedor The current object (for fluent API support)
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
     * If this Proveedor is new, it will return
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
                    ->filterByProveedor($this)
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
     * @return Proveedor The current object (for fluent API support)
     */
    public function setComprass(PropelCollection $comprass, PropelPDO $con = null)
    {
        $comprassToDelete = $this->getComprass(new Criteria(), $con)->diff($comprass);


        $this->comprassScheduledForDeletion = $comprassToDelete;

        foreach ($comprassToDelete as $comprasRemoved) {
            $comprasRemoved->setProveedor(null);
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
                ->filterByProveedor($this)
                ->count($con);
        }

        return count($this->collComprass);
    }

    /**
     * Method called to associate a Compras object to this object
     * through the Compras foreign key attribute.
     *
     * @param    Compras $l Compras
     * @return Proveedor The current object (for fluent API support)
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
        $compras->setProveedor($this);
    }

    /**
     * @param	Compras $compras The compras object to remove.
     * @return Proveedor The current object (for fluent API support)
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
            $compras->setProveedor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Proveedor is new, it will return
     * an empty collection; or if this Proveedor has previously
     * been saved, it will retrieve related Comprass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Proveedor.
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
     * Otherwise if this Proveedor is new, it will return
     * an empty collection; or if this Proveedor has previously
     * been saved, it will retrieve related Comprass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Proveedor.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Compras[] List of Compras objects
     */
    public function getComprassJoinInventario($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ComprasQuery::create(null, $criteria);
        $query->joinWith('Inventario', $join_behavior);

        return $this->getComprass($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Proveedor is new, it will return
     * an empty collection; or if this Proveedor has previously
     * been saved, it will retrieve related Comprass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Proveedor.
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
     * Clears out the collInventarios collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Proveedor The current object (for fluent API support)
     * @see        addInventarios()
     */
    public function clearInventarios()
    {
        $this->collInventarios = null; // important to set this to null since that means it is uninitialized
        $this->collInventariosPartial = null;

        return $this;
    }

    /**
     * reset is the collInventarios collection loaded partially
     *
     * @return void
     */
    public function resetPartialInventarios($v = true)
    {
        $this->collInventariosPartial = $v;
    }

    /**
     * Initializes the collInventarios collection.
     *
     * By default this just sets the collInventarios collection to an empty array (like clearcollInventarios());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInventarios($overrideExisting = true)
    {
        if (null !== $this->collInventarios && !$overrideExisting) {
            return;
        }
        $this->collInventarios = new PropelObjectCollection();
        $this->collInventarios->setModel('Inventario');
    }

    /**
     * Gets an array of Inventario objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Proveedor is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Inventario[] List of Inventario objects
     * @throws PropelException
     */
    public function getInventarios($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collInventariosPartial && !$this->isNew();
        if (null === $this->collInventarios || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInventarios) {
                // return empty collection
                $this->initInventarios();
            } else {
                $collInventarios = InventarioQuery::create(null, $criteria)
                    ->filterByProveedor($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collInventariosPartial && count($collInventarios)) {
                      $this->initInventarios(false);

                      foreach ($collInventarios as $obj) {
                        if (false == $this->collInventarios->contains($obj)) {
                          $this->collInventarios->append($obj);
                        }
                      }

                      $this->collInventariosPartial = true;
                    }

                    $collInventarios->getInternalIterator()->rewind();

                    return $collInventarios;
                }

                if ($partial && $this->collInventarios) {
                    foreach ($this->collInventarios as $obj) {
                        if ($obj->isNew()) {
                            $collInventarios[] = $obj;
                        }
                    }
                }

                $this->collInventarios = $collInventarios;
                $this->collInventariosPartial = false;
            }
        }

        return $this->collInventarios;
    }

    /**
     * Sets a collection of Inventario objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $inventarios A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Proveedor The current object (for fluent API support)
     */
    public function setInventarios(PropelCollection $inventarios, PropelPDO $con = null)
    {
        $inventariosToDelete = $this->getInventarios(new Criteria(), $con)->diff($inventarios);


        $this->inventariosScheduledForDeletion = $inventariosToDelete;

        foreach ($inventariosToDelete as $inventarioRemoved) {
            $inventarioRemoved->setProveedor(null);
        }

        $this->collInventarios = null;
        foreach ($inventarios as $inventario) {
            $this->addInventario($inventario);
        }

        $this->collInventarios = $inventarios;
        $this->collInventariosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Inventario objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Inventario objects.
     * @throws PropelException
     */
    public function countInventarios(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collInventariosPartial && !$this->isNew();
        if (null === $this->collInventarios || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInventarios) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInventarios());
            }
            $query = InventarioQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProveedor($this)
                ->count($con);
        }

        return count($this->collInventarios);
    }

    /**
     * Method called to associate a Inventario object to this object
     * through the Inventario foreign key attribute.
     *
     * @param    Inventario $l Inventario
     * @return Proveedor The current object (for fluent API support)
     */
    public function addInventario(Inventario $l)
    {
        if ($this->collInventarios === null) {
            $this->initInventarios();
            $this->collInventariosPartial = true;
        }

        if (!in_array($l, $this->collInventarios->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddInventario($l);

            if ($this->inventariosScheduledForDeletion and $this->inventariosScheduledForDeletion->contains($l)) {
                $this->inventariosScheduledForDeletion->remove($this->inventariosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Inventario $inventario The inventario object to add.
     */
    protected function doAddInventario($inventario)
    {
        $this->collInventarios[]= $inventario;
        $inventario->setProveedor($this);
    }

    /**
     * @param	Inventario $inventario The inventario object to remove.
     * @return Proveedor The current object (for fluent API support)
     */
    public function removeInventario($inventario)
    {
        if ($this->getInventarios()->contains($inventario)) {
            $this->collInventarios->remove($this->collInventarios->search($inventario));
            if (null === $this->inventariosScheduledForDeletion) {
                $this->inventariosScheduledForDeletion = clone $this->collInventarios;
                $this->inventariosScheduledForDeletion->clear();
            }
            $this->inventariosScheduledForDeletion[]= $inventario;
            $inventario->setProveedor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Proveedor is new, it will return
     * an empty collection; or if this Proveedor has previously
     * been saved, it will retrieve related Inventarios from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Proveedor.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Inventario[] List of Inventario objects
     */
    public function getInventariosJoinProducto($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = InventarioQuery::create(null, $criteria);
        $query->joinWith('Producto', $join_behavior);

        return $this->getInventarios($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->nombre = null;
        $this->encargado = null;
        $this->nit = null;
        $this->dpi = null;
        $this->direccion = null;
        $this->telefono = null;
        $this->movil = null;
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
            if ($this->collInventarios) {
                foreach ($this->collInventarios as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collComprass instanceof PropelCollection) {
            $this->collComprass->clearIterator();
        }
        $this->collComprass = null;
        if ($this->collInventarios instanceof PropelCollection) {
            $this->collInventarios->clearIterator();
        }
        $this->collInventarios = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string The value of the 'nombre' column
     */
    public function __toString()
    {
        return (string) $this->getNombre();
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
