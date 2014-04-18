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
use TS\BodegaBundle\Model\Clientes;
use TS\BodegaBundle\Model\ClientesQuery;
use TS\BodegaBundle\Model\Compras;
use TS\BodegaBundle\Model\ComprasQuery;
use TS\BodegaBundle\Model\Factura;
use TS\BodegaBundle\Model\FacturaDetalle;
use TS\BodegaBundle\Model\FacturaDetalleQuery;
use TS\BodegaBundle\Model\FacturaPeer;
use TS\BodegaBundle\Model\FacturaQuery;
use TS\BodegaBundle\Model\Ventas;
use TS\BodegaBundle\Model\VentasQuery;

abstract class BaseFactura extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'TS\\BodegaBundle\\Model\\FacturaPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        FacturaPeer
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
     * The value for the numero_factura field.
     * @var        string
     */
    protected $numero_factura;

    /**
     * The value for the fecha field.
     * @var        string
     */
    protected $fecha;

    /**
     * The value for the tipo field.
     * @var        string
     */
    protected $tipo;

    /**
     * The value for the clientes_id field.
     * @var        int
     */
    protected $clientes_id;

    /**
     * The value for the subtotal field.
     * @var        string
     */
    protected $subtotal;

    /**
     * The value for the impuesto field.
     * @var        string
     */
    protected $impuesto;

    /**
     * The value for the descuento field.
     * @var        string
     */
    protected $descuento;

    /**
     * The value for the total field.
     * @var        string
     */
    protected $total;

    /**
     * @var        Clientes
     */
    protected $aClientes;

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
     * @var        PropelObjectCollection|FacturaDetalle[] Collection to store aggregation of FacturaDetalle objects.
     */
    protected $collFacturaDetalles;
    protected $collFacturaDetallesPartial;

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
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $facturaDetallesScheduledForDeletion = null;

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
     * Get the [numero_factura] column value.
     *
     * @return string
     */
    public function getNumeroFactura()
    {

        return $this->numero_factura;
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
     * Get the [tipo] column value.
     *
     * @return string
     */
    public function getTipo()
    {

        return $this->tipo;
    }

    /**
     * Get the [clientes_id] column value.
     *
     * @return int
     */
    public function getClientesId()
    {

        return $this->clientes_id;
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
     * Get the [impuesto] column value.
     *
     * @return string
     */
    public function getImpuesto()
    {

        return $this->impuesto;
    }

    /**
     * Get the [descuento] column value.
     *
     * @return string
     */
    public function getDescuento()
    {

        return $this->descuento;
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
     * @return Factura The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = FacturaPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [numero_factura] column.
     *
     * @param  string $v new value
     * @return Factura The current object (for fluent API support)
     */
    public function setNumeroFactura($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->numero_factura !== $v) {
            $this->numero_factura = $v;
            $this->modifiedColumns[] = FacturaPeer::NUMERO_FACTURA;
        }


        return $this;
    } // setNumeroFactura()

    /**
     * Sets the value of [fecha] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Factura The current object (for fluent API support)
     */
    public function setFecha($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha !== null || $dt !== null) {
            $currentDateAsString = ($this->fecha !== null && $tmpDt = new DateTime($this->fecha)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->fecha = $newDateAsString;
                $this->modifiedColumns[] = FacturaPeer::FECHA;
            }
        } // if either are not null


        return $this;
    } // setFecha()

    /**
     * Set the value of [tipo] column.
     *
     * @param  string $v new value
     * @return Factura The current object (for fluent API support)
     */
    public function setTipo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tipo !== $v) {
            $this->tipo = $v;
            $this->modifiedColumns[] = FacturaPeer::TIPO;
        }


        return $this;
    } // setTipo()

    /**
     * Set the value of [clientes_id] column.
     *
     * @param  int $v new value
     * @return Factura The current object (for fluent API support)
     */
    public function setClientesId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->clientes_id !== $v) {
            $this->clientes_id = $v;
            $this->modifiedColumns[] = FacturaPeer::CLIENTES_ID;
        }

        if ($this->aClientes !== null && $this->aClientes->getId() !== $v) {
            $this->aClientes = null;
        }


        return $this;
    } // setClientesId()

    /**
     * Set the value of [subtotal] column.
     *
     * @param  string $v new value
     * @return Factura The current object (for fluent API support)
     */
    public function setSubtotal($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->subtotal !== $v) {
            $this->subtotal = $v;
            $this->modifiedColumns[] = FacturaPeer::SUBTOTAL;
        }


        return $this;
    } // setSubtotal()

    /**
     * Set the value of [impuesto] column.
     *
     * @param  string $v new value
     * @return Factura The current object (for fluent API support)
     */
    public function setImpuesto($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->impuesto !== $v) {
            $this->impuesto = $v;
            $this->modifiedColumns[] = FacturaPeer::IMPUESTO;
        }


        return $this;
    } // setImpuesto()

    /**
     * Set the value of [descuento] column.
     *
     * @param  string $v new value
     * @return Factura The current object (for fluent API support)
     */
    public function setDescuento($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->descuento !== $v) {
            $this->descuento = $v;
            $this->modifiedColumns[] = FacturaPeer::DESCUENTO;
        }


        return $this;
    } // setDescuento()

    /**
     * Set the value of [total] column.
     *
     * @param  string $v new value
     * @return Factura The current object (for fluent API support)
     */
    public function setTotal($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->total !== $v) {
            $this->total = $v;
            $this->modifiedColumns[] = FacturaPeer::TOTAL;
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
            $this->numero_factura = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->fecha = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->tipo = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->clientes_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->subtotal = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->impuesto = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->descuento = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->total = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 9; // 9 = FacturaPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Factura object", $e);
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

        if ($this->aClientes !== null && $this->clientes_id !== $this->aClientes->getId()) {
            $this->aClientes = null;
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
            $con = Propel::getConnection(FacturaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = FacturaPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aClientes = null;
            $this->collComprass = null;

            $this->collVentass = null;

            $this->collFacturaDetalles = null;

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
            $con = Propel::getConnection(FacturaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = FacturaQuery::create()
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
            $con = Propel::getConnection(FacturaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                FacturaPeer::addInstanceToPool($this);
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

            if ($this->aClientes !== null) {
                if ($this->aClientes->isModified() || $this->aClientes->isNew()) {
                    $affectedRows += $this->aClientes->save($con);
                }
                $this->setClientes($this->aClientes);
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

            if ($this->facturaDetallesScheduledForDeletion !== null) {
                if (!$this->facturaDetallesScheduledForDeletion->isEmpty()) {
                    foreach ($this->facturaDetallesScheduledForDeletion as $facturaDetalle) {
                        // need to save related object because we set the relation to null
                        $facturaDetalle->save($con);
                    }
                    $this->facturaDetallesScheduledForDeletion = null;
                }
            }

            if ($this->collFacturaDetalles !== null) {
                foreach ($this->collFacturaDetalles as $referrerFK) {
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

        $this->modifiedColumns[] = FacturaPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FacturaPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FacturaPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(FacturaPeer::NUMERO_FACTURA)) {
            $modifiedColumns[':p' . $index++]  = '`numero_factura`';
        }
        if ($this->isColumnModified(FacturaPeer::FECHA)) {
            $modifiedColumns[':p' . $index++]  = '`fecha`';
        }
        if ($this->isColumnModified(FacturaPeer::TIPO)) {
            $modifiedColumns[':p' . $index++]  = '`tipo`';
        }
        if ($this->isColumnModified(FacturaPeer::CLIENTES_ID)) {
            $modifiedColumns[':p' . $index++]  = '`clientes_id`';
        }
        if ($this->isColumnModified(FacturaPeer::SUBTOTAL)) {
            $modifiedColumns[':p' . $index++]  = '`subtotal`';
        }
        if ($this->isColumnModified(FacturaPeer::IMPUESTO)) {
            $modifiedColumns[':p' . $index++]  = '`impuesto`';
        }
        if ($this->isColumnModified(FacturaPeer::DESCUENTO)) {
            $modifiedColumns[':p' . $index++]  = '`descuento`';
        }
        if ($this->isColumnModified(FacturaPeer::TOTAL)) {
            $modifiedColumns[':p' . $index++]  = '`total`';
        }

        $sql = sprintf(
            'INSERT INTO `factura` (%s) VALUES (%s)',
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
                    case '`numero_factura`':
                        $stmt->bindValue($identifier, $this->numero_factura, PDO::PARAM_STR);
                        break;
                    case '`fecha`':
                        $stmt->bindValue($identifier, $this->fecha, PDO::PARAM_STR);
                        break;
                    case '`tipo`':
                        $stmt->bindValue($identifier, $this->tipo, PDO::PARAM_STR);
                        break;
                    case '`clientes_id`':
                        $stmt->bindValue($identifier, $this->clientes_id, PDO::PARAM_INT);
                        break;
                    case '`subtotal`':
                        $stmt->bindValue($identifier, $this->subtotal, PDO::PARAM_STR);
                        break;
                    case '`impuesto`':
                        $stmt->bindValue($identifier, $this->impuesto, PDO::PARAM_STR);
                        break;
                    case '`descuento`':
                        $stmt->bindValue($identifier, $this->descuento, PDO::PARAM_STR);
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

            if ($this->aClientes !== null) {
                if (!$this->aClientes->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aClientes->getValidationFailures());
                }
            }


            if (($retval = FacturaPeer::doValidate($this, $columns)) !== true) {
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

                if ($this->collFacturaDetalles !== null) {
                    foreach ($this->collFacturaDetalles as $referrerFK) {
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
        $pos = FacturaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getNumeroFactura();
                break;
            case 2:
                return $this->getFecha();
                break;
            case 3:
                return $this->getTipo();
                break;
            case 4:
                return $this->getClientesId();
                break;
            case 5:
                return $this->getSubtotal();
                break;
            case 6:
                return $this->getImpuesto();
                break;
            case 7:
                return $this->getDescuento();
                break;
            case 8:
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
        if (isset($alreadyDumpedObjects['Factura'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Factura'][$this->getPrimaryKey()] = true;
        $keys = FacturaPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getNumeroFactura(),
            $keys[2] => $this->getFecha(),
            $keys[3] => $this->getTipo(),
            $keys[4] => $this->getClientesId(),
            $keys[5] => $this->getSubtotal(),
            $keys[6] => $this->getImpuesto(),
            $keys[7] => $this->getDescuento(),
            $keys[8] => $this->getTotal(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aClientes) {
                $result['Clientes'] = $this->aClientes->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collComprass) {
                $result['Comprass'] = $this->collComprass->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collVentass) {
                $result['Ventass'] = $this->collVentass->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFacturaDetalles) {
                $result['FacturaDetalles'] = $this->collFacturaDetalles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = FacturaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setNumeroFactura($value);
                break;
            case 2:
                $this->setFecha($value);
                break;
            case 3:
                $this->setTipo($value);
                break;
            case 4:
                $this->setClientesId($value);
                break;
            case 5:
                $this->setSubtotal($value);
                break;
            case 6:
                $this->setImpuesto($value);
                break;
            case 7:
                $this->setDescuento($value);
                break;
            case 8:
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
        $keys = FacturaPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setNumeroFactura($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setFecha($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setTipo($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setClientesId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSubtotal($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setImpuesto($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDescuento($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setTotal($arr[$keys[8]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FacturaPeer::DATABASE_NAME);

        if ($this->isColumnModified(FacturaPeer::ID)) $criteria->add(FacturaPeer::ID, $this->id);
        if ($this->isColumnModified(FacturaPeer::NUMERO_FACTURA)) $criteria->add(FacturaPeer::NUMERO_FACTURA, $this->numero_factura);
        if ($this->isColumnModified(FacturaPeer::FECHA)) $criteria->add(FacturaPeer::FECHA, $this->fecha);
        if ($this->isColumnModified(FacturaPeer::TIPO)) $criteria->add(FacturaPeer::TIPO, $this->tipo);
        if ($this->isColumnModified(FacturaPeer::CLIENTES_ID)) $criteria->add(FacturaPeer::CLIENTES_ID, $this->clientes_id);
        if ($this->isColumnModified(FacturaPeer::SUBTOTAL)) $criteria->add(FacturaPeer::SUBTOTAL, $this->subtotal);
        if ($this->isColumnModified(FacturaPeer::IMPUESTO)) $criteria->add(FacturaPeer::IMPUESTO, $this->impuesto);
        if ($this->isColumnModified(FacturaPeer::DESCUENTO)) $criteria->add(FacturaPeer::DESCUENTO, $this->descuento);
        if ($this->isColumnModified(FacturaPeer::TOTAL)) $criteria->add(FacturaPeer::TOTAL, $this->total);

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
        $criteria = new Criteria(FacturaPeer::DATABASE_NAME);
        $criteria->add(FacturaPeer::ID, $this->id);

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
     * @param object $copyObj An object of Factura (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setNumeroFactura($this->getNumeroFactura());
        $copyObj->setFecha($this->getFecha());
        $copyObj->setTipo($this->getTipo());
        $copyObj->setClientesId($this->getClientesId());
        $copyObj->setSubtotal($this->getSubtotal());
        $copyObj->setImpuesto($this->getImpuesto());
        $copyObj->setDescuento($this->getDescuento());
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

            foreach ($this->getFacturaDetalles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFacturaDetalle($relObj->copy($deepCopy));
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
     * @return Factura Clone of current object.
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
     * @return FacturaPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new FacturaPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Clientes object.
     *
     * @param                  Clientes $v
     * @return Factura The current object (for fluent API support)
     * @throws PropelException
     */
    public function setClientes(Clientes $v = null)
    {
        if ($v === null) {
            $this->setClientesId(NULL);
        } else {
            $this->setClientesId($v->getId());
        }

        $this->aClientes = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Clientes object, it will not be re-added.
        if ($v !== null) {
            $v->addFactura($this);
        }


        return $this;
    }


    /**
     * Get the associated Clientes object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Clientes The associated Clientes object.
     * @throws PropelException
     */
    public function getClientes(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aClientes === null && ($this->clientes_id !== null) && $doQuery) {
            $this->aClientes = ClientesQuery::create()->findPk($this->clientes_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aClientes->addFacturas($this);
             */
        }

        return $this->aClientes;
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
        if ('FacturaDetalle' == $relationName) {
            $this->initFacturaDetalles();
        }
    }

    /**
     * Clears out the collComprass collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Factura The current object (for fluent API support)
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
     * If this Factura is new, it will return
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
                    ->filterByFactura($this)
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
     * @return Factura The current object (for fluent API support)
     */
    public function setComprass(PropelCollection $comprass, PropelPDO $con = null)
    {
        $comprassToDelete = $this->getComprass(new Criteria(), $con)->diff($comprass);


        $this->comprassScheduledForDeletion = $comprassToDelete;

        foreach ($comprassToDelete as $comprasRemoved) {
            $comprasRemoved->setFactura(null);
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
                ->filterByFactura($this)
                ->count($con);
        }

        return count($this->collComprass);
    }

    /**
     * Method called to associate a Compras object to this object
     * through the Compras foreign key attribute.
     *
     * @param    Compras $l Compras
     * @return Factura The current object (for fluent API support)
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
        $compras->setFactura($this);
    }

    /**
     * @param	Compras $compras The compras object to remove.
     * @return Factura The current object (for fluent API support)
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
            $compras->setFactura(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Factura is new, it will return
     * an empty collection; or if this Factura has previously
     * been saved, it will retrieve related Comprass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Factura.
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
     * Otherwise if this Factura is new, it will return
     * an empty collection; or if this Factura has previously
     * been saved, it will retrieve related Comprass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Factura.
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
     * Otherwise if this Factura is new, it will return
     * an empty collection; or if this Factura has previously
     * been saved, it will retrieve related Comprass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Factura.
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
     * @return Factura The current object (for fluent API support)
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
     * If this Factura is new, it will return
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
                    ->filterByFactura($this)
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
     * @return Factura The current object (for fluent API support)
     */
    public function setVentass(PropelCollection $ventass, PropelPDO $con = null)
    {
        $ventassToDelete = $this->getVentass(new Criteria(), $con)->diff($ventass);


        $this->ventassScheduledForDeletion = $ventassToDelete;

        foreach ($ventassToDelete as $ventasRemoved) {
            $ventasRemoved->setFactura(null);
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
                ->filterByFactura($this)
                ->count($con);
        }

        return count($this->collVentass);
    }

    /**
     * Method called to associate a Ventas object to this object
     * through the Ventas foreign key attribute.
     *
     * @param    Ventas $l Ventas
     * @return Factura The current object (for fluent API support)
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
        $ventas->setFactura($this);
    }

    /**
     * @param	Ventas $ventas The ventas object to remove.
     * @return Factura The current object (for fluent API support)
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
            $ventas->setFactura(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Factura is new, it will return
     * an empty collection; or if this Factura has previously
     * been saved, it will retrieve related Ventass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Factura.
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
     * Otherwise if this Factura is new, it will return
     * an empty collection; or if this Factura has previously
     * been saved, it will retrieve related Ventass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Factura.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Ventas[] List of Ventas objects
     */
    public function getVentassJoinInventario($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = VentasQuery::create(null, $criteria);
        $query->joinWith('Inventario', $join_behavior);

        return $this->getVentass($query, $con);
    }

    /**
     * Clears out the collFacturaDetalles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Factura The current object (for fluent API support)
     * @see        addFacturaDetalles()
     */
    public function clearFacturaDetalles()
    {
        $this->collFacturaDetalles = null; // important to set this to null since that means it is uninitialized
        $this->collFacturaDetallesPartial = null;

        return $this;
    }

    /**
     * reset is the collFacturaDetalles collection loaded partially
     *
     * @return void
     */
    public function resetPartialFacturaDetalles($v = true)
    {
        $this->collFacturaDetallesPartial = $v;
    }

    /**
     * Initializes the collFacturaDetalles collection.
     *
     * By default this just sets the collFacturaDetalles collection to an empty array (like clearcollFacturaDetalles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFacturaDetalles($overrideExisting = true)
    {
        if (null !== $this->collFacturaDetalles && !$overrideExisting) {
            return;
        }
        $this->collFacturaDetalles = new PropelObjectCollection();
        $this->collFacturaDetalles->setModel('FacturaDetalle');
    }

    /**
     * Gets an array of FacturaDetalle objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Factura is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FacturaDetalle[] List of FacturaDetalle objects
     * @throws PropelException
     */
    public function getFacturaDetalles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFacturaDetallesPartial && !$this->isNew();
        if (null === $this->collFacturaDetalles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFacturaDetalles) {
                // return empty collection
                $this->initFacturaDetalles();
            } else {
                $collFacturaDetalles = FacturaDetalleQuery::create(null, $criteria)
                    ->filterByFactura($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFacturaDetallesPartial && count($collFacturaDetalles)) {
                      $this->initFacturaDetalles(false);

                      foreach ($collFacturaDetalles as $obj) {
                        if (false == $this->collFacturaDetalles->contains($obj)) {
                          $this->collFacturaDetalles->append($obj);
                        }
                      }

                      $this->collFacturaDetallesPartial = true;
                    }

                    $collFacturaDetalles->getInternalIterator()->rewind();

                    return $collFacturaDetalles;
                }

                if ($partial && $this->collFacturaDetalles) {
                    foreach ($this->collFacturaDetalles as $obj) {
                        if ($obj->isNew()) {
                            $collFacturaDetalles[] = $obj;
                        }
                    }
                }

                $this->collFacturaDetalles = $collFacturaDetalles;
                $this->collFacturaDetallesPartial = false;
            }
        }

        return $this->collFacturaDetalles;
    }

    /**
     * Sets a collection of FacturaDetalle objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $facturaDetalles A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Factura The current object (for fluent API support)
     */
    public function setFacturaDetalles(PropelCollection $facturaDetalles, PropelPDO $con = null)
    {
        $facturaDetallesToDelete = $this->getFacturaDetalles(new Criteria(), $con)->diff($facturaDetalles);


        $this->facturaDetallesScheduledForDeletion = $facturaDetallesToDelete;

        foreach ($facturaDetallesToDelete as $facturaDetalleRemoved) {
            $facturaDetalleRemoved->setFactura(null);
        }

        $this->collFacturaDetalles = null;
        foreach ($facturaDetalles as $facturaDetalle) {
            $this->addFacturaDetalle($facturaDetalle);
        }

        $this->collFacturaDetalles = $facturaDetalles;
        $this->collFacturaDetallesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FacturaDetalle objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FacturaDetalle objects.
     * @throws PropelException
     */
    public function countFacturaDetalles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFacturaDetallesPartial && !$this->isNew();
        if (null === $this->collFacturaDetalles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFacturaDetalles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFacturaDetalles());
            }
            $query = FacturaDetalleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFactura($this)
                ->count($con);
        }

        return count($this->collFacturaDetalles);
    }

    /**
     * Method called to associate a FacturaDetalle object to this object
     * through the FacturaDetalle foreign key attribute.
     *
     * @param    FacturaDetalle $l FacturaDetalle
     * @return Factura The current object (for fluent API support)
     */
    public function addFacturaDetalle(FacturaDetalle $l)
    {
        if ($this->collFacturaDetalles === null) {
            $this->initFacturaDetalles();
            $this->collFacturaDetallesPartial = true;
        }

        if (!in_array($l, $this->collFacturaDetalles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFacturaDetalle($l);

            if ($this->facturaDetallesScheduledForDeletion and $this->facturaDetallesScheduledForDeletion->contains($l)) {
                $this->facturaDetallesScheduledForDeletion->remove($this->facturaDetallesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	FacturaDetalle $facturaDetalle The facturaDetalle object to add.
     */
    protected function doAddFacturaDetalle($facturaDetalle)
    {
        $this->collFacturaDetalles[]= $facturaDetalle;
        $facturaDetalle->setFactura($this);
    }

    /**
     * @param	FacturaDetalle $facturaDetalle The facturaDetalle object to remove.
     * @return Factura The current object (for fluent API support)
     */
    public function removeFacturaDetalle($facturaDetalle)
    {
        if ($this->getFacturaDetalles()->contains($facturaDetalle)) {
            $this->collFacturaDetalles->remove($this->collFacturaDetalles->search($facturaDetalle));
            if (null === $this->facturaDetallesScheduledForDeletion) {
                $this->facturaDetallesScheduledForDeletion = clone $this->collFacturaDetalles;
                $this->facturaDetallesScheduledForDeletion->clear();
            }
            $this->facturaDetallesScheduledForDeletion[]= $facturaDetalle;
            $facturaDetalle->setFactura(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Factura is new, it will return
     * an empty collection; or if this Factura has previously
     * been saved, it will retrieve related FacturaDetalles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Factura.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FacturaDetalle[] List of FacturaDetalle objects
     */
    public function getFacturaDetallesJoinProducto($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FacturaDetalleQuery::create(null, $criteria);
        $query->joinWith('Producto', $join_behavior);

        return $this->getFacturaDetalles($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->numero_factura = null;
        $this->fecha = null;
        $this->tipo = null;
        $this->clientes_id = null;
        $this->subtotal = null;
        $this->impuesto = null;
        $this->descuento = null;
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
            if ($this->collFacturaDetalles) {
                foreach ($this->collFacturaDetalles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aClientes instanceof Persistent) {
              $this->aClientes->clearAllReferences($deep);
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
        if ($this->collFacturaDetalles instanceof PropelCollection) {
            $this->collFacturaDetalles->clearIterator();
        }
        $this->collFacturaDetalles = null;
        $this->aClientes = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FacturaPeer::DEFAULT_STRING_FORMAT);
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
