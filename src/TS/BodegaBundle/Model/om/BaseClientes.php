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
use TS\BodegaBundle\Model\Clientes;
use TS\BodegaBundle\Model\ClientesPeer;
use TS\BodegaBundle\Model\ClientesQuery;

abstract class BaseClientes extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'TS\\BodegaBundle\\Model\\ClientesPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ClientesPeer
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
     * The value for the nombres field.
     * @var        string
     */
    protected $nombres;

    /**
     * The value for the apellidos field.
     * @var        string
     */
    protected $apellidos;

    /**
     * The value for the nombre_completo field.
     * @var        string
     */
    protected $nombre_completo;

    /**
     * The value for the dpi field.
     * @var        string
     */
    protected $dpi;

    /**
     * The value for the nit field.
     * @var        string
     */
    protected $nit;

    /**
     * The value for the telefono field.
     * @var        string
     */
    protected $telefono;

    /**
     * The value for the direccion field.
     * @var        string
     */
    protected $direccion;

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
     * Get the [nombres] column value.
     *
     * @return string
     */
    public function getNombres()
    {

        return $this->nombres;
    }

    /**
     * Get the [apellidos] column value.
     *
     * @return string
     */
    public function getApellidos()
    {

        return $this->apellidos;
    }

    /**
     * Get the [nombre_completo] column value.
     *
     * @return string
     */
    public function getNombreCompleto()
    {

        return $this->nombre_completo;
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
     * Get the [nit] column value.
     *
     * @return string
     */
    public function getNit()
    {

        return $this->nit;
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
     * Get the [direccion] column value.
     *
     * @return string
     */
    public function getDireccion()
    {

        return $this->direccion;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Clientes The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ClientesPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [nombres] column.
     *
     * @param  string $v new value
     * @return Clientes The current object (for fluent API support)
     */
    public function setNombres($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombres !== $v) {
            $this->nombres = $v;
            $this->modifiedColumns[] = ClientesPeer::NOMBRES;
        }


        return $this;
    } // setNombres()

    /**
     * Set the value of [apellidos] column.
     *
     * @param  string $v new value
     * @return Clientes The current object (for fluent API support)
     */
    public function setApellidos($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->apellidos !== $v) {
            $this->apellidos = $v;
            $this->modifiedColumns[] = ClientesPeer::APELLIDOS;
        }


        return $this;
    } // setApellidos()

    /**
     * Set the value of [nombre_completo] column.
     *
     * @param  string $v new value
     * @return Clientes The current object (for fluent API support)
     */
    public function setNombreCompleto($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombre_completo !== $v) {
            $this->nombre_completo = $v;
            $this->modifiedColumns[] = ClientesPeer::NOMBRE_COMPLETO;
        }


        return $this;
    } // setNombreCompleto()

    /**
     * Set the value of [dpi] column.
     *
     * @param  string $v new value
     * @return Clientes The current object (for fluent API support)
     */
    public function setDpi($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->dpi !== $v) {
            $this->dpi = $v;
            $this->modifiedColumns[] = ClientesPeer::DPI;
        }


        return $this;
    } // setDpi()

    /**
     * Set the value of [nit] column.
     *
     * @param  string $v new value
     * @return Clientes The current object (for fluent API support)
     */
    public function setNit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nit !== $v) {
            $this->nit = $v;
            $this->modifiedColumns[] = ClientesPeer::NIT;
        }


        return $this;
    } // setNit()

    /**
     * Set the value of [telefono] column.
     *
     * @param  string $v new value
     * @return Clientes The current object (for fluent API support)
     */
    public function setTelefono($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->telefono !== $v) {
            $this->telefono = $v;
            $this->modifiedColumns[] = ClientesPeer::TELEFONO;
        }


        return $this;
    } // setTelefono()

    /**
     * Set the value of [direccion] column.
     *
     * @param  string $v new value
     * @return Clientes The current object (for fluent API support)
     */
    public function setDireccion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->direccion !== $v) {
            $this->direccion = $v;
            $this->modifiedColumns[] = ClientesPeer::DIRECCION;
        }


        return $this;
    } // setDireccion()

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
            $this->nombres = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->apellidos = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->nombre_completo = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->dpi = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->nit = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->telefono = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->direccion = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = ClientesPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Clientes object", $e);
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
            $con = Propel::getConnection(ClientesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ClientesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

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
            $con = Propel::getConnection(ClientesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ClientesQuery::create()
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
            $con = Propel::getConnection(ClientesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ClientesPeer::addInstanceToPool($this);
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

        $this->modifiedColumns[] = ClientesPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ClientesPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ClientesPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ClientesPeer::NOMBRES)) {
            $modifiedColumns[':p' . $index++]  = '`nombres`';
        }
        if ($this->isColumnModified(ClientesPeer::APELLIDOS)) {
            $modifiedColumns[':p' . $index++]  = '`apellidos`';
        }
        if ($this->isColumnModified(ClientesPeer::NOMBRE_COMPLETO)) {
            $modifiedColumns[':p' . $index++]  = '`nombre_completo`';
        }
        if ($this->isColumnModified(ClientesPeer::DPI)) {
            $modifiedColumns[':p' . $index++]  = '`dpi`';
        }
        if ($this->isColumnModified(ClientesPeer::NIT)) {
            $modifiedColumns[':p' . $index++]  = '`nit`';
        }
        if ($this->isColumnModified(ClientesPeer::TELEFONO)) {
            $modifiedColumns[':p' . $index++]  = '`telefono`';
        }
        if ($this->isColumnModified(ClientesPeer::DIRECCION)) {
            $modifiedColumns[':p' . $index++]  = '`direccion`';
        }

        $sql = sprintf(
            'INSERT INTO `clientes` (%s) VALUES (%s)',
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
                    case '`nombres`':
                        $stmt->bindValue($identifier, $this->nombres, PDO::PARAM_STR);
                        break;
                    case '`apellidos`':
                        $stmt->bindValue($identifier, $this->apellidos, PDO::PARAM_STR);
                        break;
                    case '`nombre_completo`':
                        $stmt->bindValue($identifier, $this->nombre_completo, PDO::PARAM_STR);
                        break;
                    case '`dpi`':
                        $stmt->bindValue($identifier, $this->dpi, PDO::PARAM_STR);
                        break;
                    case '`nit`':
                        $stmt->bindValue($identifier, $this->nit, PDO::PARAM_STR);
                        break;
                    case '`telefono`':
                        $stmt->bindValue($identifier, $this->telefono, PDO::PARAM_STR);
                        break;
                    case '`direccion`':
                        $stmt->bindValue($identifier, $this->direccion, PDO::PARAM_STR);
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


            if (($retval = ClientesPeer::doValidate($this, $columns)) !== true) {
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
        $pos = ClientesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getNombres();
                break;
            case 2:
                return $this->getApellidos();
                break;
            case 3:
                return $this->getNombreCompleto();
                break;
            case 4:
                return $this->getDpi();
                break;
            case 5:
                return $this->getNit();
                break;
            case 6:
                return $this->getTelefono();
                break;
            case 7:
                return $this->getDireccion();
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
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {
        if (isset($alreadyDumpedObjects['Clientes'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Clientes'][$this->getPrimaryKey()] = true;
        $keys = ClientesPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getNombres(),
            $keys[2] => $this->getApellidos(),
            $keys[3] => $this->getNombreCompleto(),
            $keys[4] => $this->getDpi(),
            $keys[5] => $this->getNit(),
            $keys[6] => $this->getTelefono(),
            $keys[7] => $this->getDireccion(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
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
        $pos = ClientesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setNombres($value);
                break;
            case 2:
                $this->setApellidos($value);
                break;
            case 3:
                $this->setNombreCompleto($value);
                break;
            case 4:
                $this->setDpi($value);
                break;
            case 5:
                $this->setNit($value);
                break;
            case 6:
                $this->setTelefono($value);
                break;
            case 7:
                $this->setDireccion($value);
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
        $keys = ClientesPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setNombres($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setApellidos($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setNombreCompleto($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDpi($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setNit($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setTelefono($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDireccion($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ClientesPeer::DATABASE_NAME);

        if ($this->isColumnModified(ClientesPeer::ID)) $criteria->add(ClientesPeer::ID, $this->id);
        if ($this->isColumnModified(ClientesPeer::NOMBRES)) $criteria->add(ClientesPeer::NOMBRES, $this->nombres);
        if ($this->isColumnModified(ClientesPeer::APELLIDOS)) $criteria->add(ClientesPeer::APELLIDOS, $this->apellidos);
        if ($this->isColumnModified(ClientesPeer::NOMBRE_COMPLETO)) $criteria->add(ClientesPeer::NOMBRE_COMPLETO, $this->nombre_completo);
        if ($this->isColumnModified(ClientesPeer::DPI)) $criteria->add(ClientesPeer::DPI, $this->dpi);
        if ($this->isColumnModified(ClientesPeer::NIT)) $criteria->add(ClientesPeer::NIT, $this->nit);
        if ($this->isColumnModified(ClientesPeer::TELEFONO)) $criteria->add(ClientesPeer::TELEFONO, $this->telefono);
        if ($this->isColumnModified(ClientesPeer::DIRECCION)) $criteria->add(ClientesPeer::DIRECCION, $this->direccion);

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
        $criteria = new Criteria(ClientesPeer::DATABASE_NAME);
        $criteria->add(ClientesPeer::ID, $this->id);

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
     * @param object $copyObj An object of Clientes (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setNombres($this->getNombres());
        $copyObj->setApellidos($this->getApellidos());
        $copyObj->setNombreCompleto($this->getNombreCompleto());
        $copyObj->setDpi($this->getDpi());
        $copyObj->setNit($this->getNit());
        $copyObj->setTelefono($this->getTelefono());
        $copyObj->setDireccion($this->getDireccion());
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
     * @return Clientes Clone of current object.
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
     * @return ClientesPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ClientesPeer();
        }

        return self::$peer;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->nombres = null;
        $this->apellidos = null;
        $this->nombre_completo = null;
        $this->dpi = null;
        $this->nit = null;
        $this->telefono = null;
        $this->direccion = null;
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

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ClientesPeer::DEFAULT_STRING_FORMAT);
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
